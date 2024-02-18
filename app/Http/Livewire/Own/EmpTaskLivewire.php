<?php

namespace App\Http\Livewire\Own;

use App\Models\Task;
use App\Models\User;
use App\Models\EmpTask;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramEmpTaskNew;
use App\Notifications\Own\TelegramEmpTaskShort;
use App\Notifications\Own\TelegramEmpTaskDelete;
use App\Notifications\Own\TelegramEmpTaskUpdate;

class EmpTaskLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    // Form Select new Invoice to cash
    public $notAttached;
    public $selectNotAttached;
    public $hasFirstPayment;
    // Form Date Section
    public $invoiceId;
    public $formDate;
    // Form Payment Section
    public $arr_tasks = [];
    // Form Final Section
    public $description;
    //FILTERS
    public $search;
    public $taskStatus = '';
    public $dateRange = null;
    public $rangeViewValue = null;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $taskUpdate;
    public $old_task_data;
    public $del_task_id;
    public $del_task_data;
    public $del_task_name;
    public $task_name_to_selete;
    public $confirmDelete = false;
    public $user_data;
    public $task_data;
    public $clientName;
    public $invoiceDate;
    public $invoiceTitle;
    public $gProgress = 0;

    protected $listeners = ['dateRangeSelected' => 'applyDateRangeFilter'];

    public function mount() {
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_WORK_ID');
        $this->user_data = User::where('status', 1)->where('role', '!=', 1)->get();
        $this->task_data = Task::where('status', 1)->get();
        $this->initializeInvoiceSelection();
    } // END FUNCTION OF PAGE LOAD

    public function initializeInvoiceSelection() {
        $attachedInvoiceIds = EmpTask::pluck('invoice_id')->toArray();
        $notAttachedInvoices = Invoice::whereNotIn('id', $attachedInvoiceIds)->get();
        $this->notAttached = $notAttachedInvoices;
    }

    public function initializeTasksArray() {
        $this->arr_tasks = [];

        $this->arr_tasks[] = [
            'name' => null,
            'task' => null,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'progress' => 0,
        ];

    
        // // If user has index 0, keep it; otherwise, keep only index 0 empty
        // if ($this->arr_tasks[0] && empty($this->arr_tasks[1])) {
        //     $this->arr_tasks = [$this->arr_tasks[0]];
        // }
    }

    public function newRecTask() {
        $this->arr_tasks[] = [
            'name' => null,
            'task' => null,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'progress' => 0,
        ];

    } // END FUNCTION OF ADD NEW SERVICE

    public function removeTask($index) {
        unset($this->arr_tasks[$index]);
        $this->arr_tasks = array_values($this->arr_tasks); // Reset array keys
    } // END FUNCTION OF ADD DELETE SERVICE

    public function enterManualeProgress() {
        $this->calculateProgress();
    }

    public function calculateProgress() {
        $sumProgress = 0;
        $this->gProgress = 0;
  
        foreach ($this->arr_tasks as $task) {
            $sumProgress += $task['progress'];
        }
        
        $this->gProgress += $sumProgress /  count($this->arr_tasks);
    }

    public function selectDataInvoice(){
        if($this->selectNotAttached){
            $taskData = Invoice::where('id', $this->selectNotAttached)->first();

            $this->invoiceDate = $taskData->invoice_date;
            $this->invoiceTitle = $taskData->description;
            $this->clientName = $taskData->client->client_name;

            $this->initializeTasksArray();
        }
    }

    protected function rules() {
        $rules = [];
        $rules['arr_tasks'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public $tempStatus;
    public function addTask(){
        try {
            $validatedData = $this->validate();
            $this->calculateProgress();
            

            if($this->gProgress == 100) {
                $this->tempStatus = 'Complete';
            } else if ($this->gProgress > 0) {
                $this->tempStatus = 'In Process';
            } else {
                $this->tempStatus = 'In Pending';
            }
            
            $task = EmpTask::create([
                'invoice_id' => $this->selectNotAttached,
                'tasks' => json_encode($validatedData['arr_tasks']),
                'progress' => $this->gProgress ?? 0,
                'task_status' => $this->tempStatus,
                'approved' => 0,
                'status' => 1,
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramEmpTaskNew(
                        $task->id,
                        $this->selectNotAttached,
                        $validatedData['arr_tasks'],
                        $this->gProgress,
                        $this->tempStatus,

                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Tasks Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->selectNotAttached = null;
            $this->initializeInvoiceSelection();
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }

    public function editTask(int $taskId){
        try {
            $taskEdit = EmpTask::find($taskId);
            $this->taskUpdate = $taskId;
            if ($taskEdit) {
                $this->invoiceDate = $taskEdit->invoice->invoice_date;
                $this->invoiceTitle = $taskEdit->invoice->description;
                $this->clientName = $taskEdit->invoice->client->client_name;
                $this->arr_tasks = json_decode($taskEdit->tasks);
                $this->gProgress = $taskEdit->progress;


                $this->old_task_data = [
                    'arr_task' => json_encode($taskEdit->tasks),
                    'taskStatus' => $taskEdit->task_status,
                    'generalProgress' => $taskEdit->progress
                ];
            } else {
                return redirect()->to('own/createTask');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT INVOICE

    public function updateTask(){
        try {
            $validatedData = $this->validate();
            $this->calculateProgress();

            if($this->gProgress == 100) {
                $this->tempStatus = 'Complete';
            } else if ($this->gProgress > 0) {
                $this->tempStatus = 'In Process';
            } else {
                $this->tempStatus = 'In Pending';
            }

            EmpTask::where('id', $this->taskUpdate)->update([
                'tasks' => json_encode($validatedData['arr_tasks']),
                'progress' => $this->gProgress ?? 0,
                'task_status' => $this->tempStatus,
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramEmpTaskUpdate(
                        $this->taskUpdate,
                        $this->selectNotAttached,
                        $validatedData['arr_tasks'],
                        $this->gProgress,
                        $this->tempStatus,
                        $this->old_task_data,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Tasks Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE INVOICE

    public function deleteTask(int $selected_task_id){
        $this->del_task_id = $selected_task_id;
        $this->del_task_data = EmpTask::find($this->del_task_id);
        if($this->del_task_data){
            // $this->del_invoice_name = $this->del_invoice_data->invoice_name;
            $this->del_task_name = 'delete';
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE INVOICE

    public function destroyTask(){
        if ($this->confirmDelete && $this->task_name_to_selete === $this->del_task_name) {

            EmpTask::find($this->del_task_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramEmpTaskDelete(
                        $this->del_task_id,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            
            $this->del_task_id = null;
            $this->del_task_data = null;
            $this->del_task_name = null;
            $this->task_name_to_selete = null;
            $this->confirmDelete = false;
            $this->initializeInvoiceSelection();
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_task_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT


    public function approved(int $item){
        $EmpApprovment = EmpTask::find($item);
        // Toggle the status (0 to 1 and 1 to 0)
        $this->old_task_data = [
            'status' => $EmpApprovment->approved
        ];

        $EmpApprovment->approved = $EmpApprovment->approved == 0 ? 1 : 0;

        if($this->telegram_channel_status == 1){
            try{
                Notification::route('toTelegram', null)
                ->notify(new TelegramEmpTaskShort(
                    $EmpApprovment->id,
                    $EmpApprovment->invoice->description,
                    $EmpApprovment->approved,

                    $this->old_task_data,
                    $this->tele_id,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $EmpApprovment->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Task Has Been Updated')]);
    }// END FUNCTION OF UPDATING PRIOEITY



    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->formDate = '';
        $this->clientName = '';
        $this->arr_tasks = [];
        $this->description = '';
        $this->gProgress = 0;
        $this->clientName = null;
        $this->invoiceDate = null;
        $this->invoiceTitle = null;

        $this->initializeTasksArray();
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal() {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public function resetFilter(){
        $this->search = null;
        $this->invoiceId= null;
        $this->dateRange = null;
        $this->rangeViewValue = null;
        $this->startDate = null;
        $this->endDate = null;
    }

    public function applyDateRangeFilter() {
        // return $this->dateRange;
    }

    public function applyFilter()
    {
        // Check if this method is being called
        $this->render();
    }
    public $startDate ;
    public $endDate ; 
    public function render() {
        if ($this->dateRange) {
            list($this->startDate, $this->endDate) = explode(' - ', $this->dateRange);
        }

        $this->rangeViewValue = $this->startDate . ' - ' . $this->endDate . ' ';


        $colspan = 9;
        $cols_th = ['#', 'Invoice ID', 'Invoice Date', 'Progress', 'Task Status','Status', 'Actions'];
        $cols_td = ['id', 'invoice.id', 'invoice.invoice_date', 'progress', 'task_status', 'status'];
                
        $data = EmpTask::with(['invoice'])
        ->when($this->search, function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhereHas('invoice', function ($subQuery) {
                    $subQuery->where('description', 'like', '%' . $this->search . '%');
                })
                ->orWhere('invoice_id', 'like', '%' . $this->search . '%');
        })
        ->when($this->startDate && $this->endDate, function ($query) {
            $query->join('invoices', 'invoices.id', '=', 'emp_tasks.invoice_id')
                ->whereBetween('invoices.invoice_date', [$this->startDate, $this->endDate])
                ->select('emp_tasks.*');
        })
        ->when($this->taskStatus !== '' && $this->taskStatus !== 'null', function ($query) {
            $query->where(function ($query) {
                $query->where('task_status', $this->taskStatus)
                    ->orWhereNull('task_status');
            });
        })
        ->orderBy('emp_tasks.progress', 'ASC')
        ->paginate(15);
    
        
        return view('livewire.own.emp-task-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}
