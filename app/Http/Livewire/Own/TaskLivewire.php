<?php

namespace App\Http\Livewire\Own;

use App\Models\Payment;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramTaskNew;
use App\Notifications\Own\TelegramTaskUpdate;
use App\Notifications\Own\TelegramTaskDelete;

class TaskLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $taskOption;
    public $status;
    //FILTERS
    public $search;
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

    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
    } // END FUNCTION OF PAGE LOAD

    protected function rules()
    {
        $rules = [];
        $rules['taskOption'] = ['required'];
        $rules['status'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addTask(){
        try {
            $validatedData = $this->validate();

            $task = Task::create([
                'task_option' => $validatedData['taskOption'],
                'status' => $validatedData['status']
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramTaskNew(
                        $task->id,
                        $validatedData['taskOption'],
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Task Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF ADD CLIENT

    public function editTask(int $taskId){
        try {
            $taskEdit = Task::find($taskId);
            $this->taskUpdate = $taskId;
            $this->old_task_data = [];

            if ($taskEdit) {
                $this->old_task_data = null;
                $this->taskOption = $taskEdit->task_option;
                $this->status = $taskEdit->status;

                $this->old_task_data = [
                    'id' => $taskEdit->id,
                    'taskOption' => $taskEdit->task_option,
                    'status' => $taskEdit->status,
                ];
            } else {
                return redirect()->to('own/task');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT CLIENT

    public function updateTask(){
        try {
            $validatedData = $this->validate();

            Task::where('id', $this->taskUpdate)->update([
                'task_option' => $validatedData['taskOption'],
                'status' => $validatedData['status'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramTaskUpdate(
                        $this->taskUpdate,
                        $validatedData['taskOption'],
                        $validatedData['status'],

                        $this->old_task_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Task Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE CLIENT

    public function deleteTask(int $selected_task_id){
        $this->del_task_id = $selected_task_id;
        $this->del_task_data = Task::find($this->del_task_id);
        if($this->del_task_data->task_option){
            $this->del_task_name = $this->del_task_data->task_option;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE CLIENT

    public function destroyTask(){
        if ($this->confirmDelete && $this->task_name_to_selete === $this->del_task_name) {
            Task::find($this->del_task_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramTaskDelete(
                        $this->del_task_id,
                        $this->del_task_data->task_option,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_task_id = null;
            $this->del_task_data = null;
            $this->del_task_name = null;
            $this->task_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Task Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_task_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->taskOption = '';
        $this->status = '';

        $this->del_task_id = null;
        $this->del_task_data = null;
        $this->del_task_name = null;
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL


    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','Task Option', 'Status', 'Actions'];
        $cols_td = ['id','task_option','status'];

        $data = Task::query()
        ->where(function ($query) {
            $query->where('task_option', 'like', '%' . $this->search . '%')
                // ->orWhere('service_name', 'like', '%' . $this->search . '%')
                ;
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
        
        return view('livewire.own.task-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}