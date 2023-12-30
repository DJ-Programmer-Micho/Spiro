<?php

namespace App\Http\Livewire\Own;

use App\Models\Cash;
use App\Models\EmpTask;
use App\Models\Invoice;
use App\Models\Task;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Notifications\Own\TelegramCashNew;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramCashDelete;

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
    public $exchange_rate = 0;
    public $formDateCash;
    public $formDateInvoice;
    public $arr_tasks = [];
    // Form Final Section
    public $description;
    public $note;

    public $dueDollar;
    public $grandTotalDollar;
    //FLAGS
    public $actionFlag = false;

    public $dueIraqi;
    public $grandTotalIraqi;
    //FILTERS
    public $cash_status = 'Not Complete';
    public $search;
    public $CashDueFilter = '';
    public $dateRange = null;
    public $rangeViewValue = null;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $cashUpdate;
    public $old_cash_data;
    public $del_cash_id;
    public $del_cash_data;
    public $del_cash_name;
    public $cash_name_to_selete;
    public $confirmDelete = false;

    //NEW
    public $user_data;
    public $task_data;
    public $clientName;
    public $invoiceDate;
    public $invoiceTitle;
    public $gProgress;

    protected $listeners = ['dateRangeSelected' => 'applyDateRangeFilter'];

    public function mount() {
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
        $this->user_data = User::get();
        $this->task_data = Task::get();
        $this->initializeInvoiceSelection();
    } // END FUNCTION OF PAGE LOAD

    public function initializeInvoiceSelection() {
        // $attachedInvoiceIds = Cash::pluck('invoice_id')->toArray();
        // $notAttachedInvoices = Invoice::whereNotIn('id', $attachedInvoiceIds)->get();
        // $this->notAttached = $notAttachedInvoices;
        $attachedInvoiceIds = EmpTask::where('progress', 100)->pluck('invoice_id')->toArray();
        $notAttachedInvoices = Invoice::whereNotIn('id', $attachedInvoiceIds)->get();
        $this->notAttached = $notAttachedInvoices;
        // dd($this->notAttached );
    }
    public function initializePaymentArray() {
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

    // public function initializePaymentEditArray($invoice, $chashId) {
    //     $this->arr_tasks = [];
    //     // Check if the invoice has a first payment
    //     $this->hasFirstPayment = $invoice && $invoice->first_pay_dollar != 0;
    //     // Retrieve additional payments from the Cash model
    //     $additionalPayments = Cash::where('id', $chashId)->first()->payments;
    //     // Check if there are additional payments and add them to the array
    //     if ($additionalPayments) {
    //         $additionalPaymentsArray = json_decode($additionalPayments, true);
    //         $this->arr_tasks = array_merge($this->arr_tasks, $additionalPaymentsArray);
    //     }

    //     $this->calculateTotals();
    // }

    public function newRecPayment() {
        $this->arr_tasks[] = [
            'name' => null,
            'task' => null,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'progress' => 0,
        ];

    } // END FUNCTION OF ADD NEW SERVICE

    public function removePayment($index) {
        unset($this->arr_tasks[$index]);
        $this->arr_tasks = array_values($this->arr_tasks); // Reset array keys
    } // END FUNCTION OF ADD DELETE SERVICE

    public function updatedFisrtPay() {
        $this->calculateProgress();
    }

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
            $cashData = Invoice::where('id', $this->selectNotAttached)->first();

            $this->invoiceDate = $cashData->invoice_date;
            $this->invoiceTitle = $cashData->description;
            $this->clientName = $cashData->client->client_name;

            $this->initializePaymentArray();
        }
    }

    protected function rules() {
        $rules = [];
        $rules['arr_tasks'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public $tempStatus;
    public function addTask(){
        // try {
            $validatedData = $this->validate();
            

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
                'status' => 1,
            ]);

            // if($this->telegram_channel_status == 1){
            //     try{
            //         Notification::route('toTelegram', null)
            //         ->notify(new TelegramCashNew(
            //             $cash->id,
            //             $validatedData['formDateCash'],
            //             $this->selectNotAttached,
            //             $validatedData['arr_tasks'],
            //             $validatedData['dueDollar'],
            //             $validatedData['dueIraqi'],
            //             $validatedData['grandTotalDollar'],
            //             $validatedData['grandTotalIraqi'],

            //             $this->tele_id
            //         ));
            //         $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            //     }  catch (\Exception $e) {
            //         $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
            //     }
            // }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Cash Receipt Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->selectNotAttached = null;
            $this->initializeInvoiceSelection();
        // } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        // }
    }

    public function editCash(int $cashId){
        try {
            $cashEdit = Cash::find($cashId);
            $this->cashUpdate = $cashId;
            if ($cashEdit) {
                $this->clientId = $cashEdit->invoice->client->id;
                $this->clientName = $cashEdit->invoice->client->client_name;
                $this->clientEmail = $cashEdit->invoice->client->email;
                $this->clientCountry = $cashEdit->invoice->client->country;
                $this->clientCity = $cashEdit->invoice->client->city;
                $this->clientAddress = $cashEdit->invoice->client->address;
                $this->clientPhoneOne = $cashEdit->invoice->client->phone_one;
                $this->clientPhoneTwo = $cashEdit->invoice->client->phone_two;

                $this->exchange_rate = $cashEdit->invoice->exchange_rate;

                $this->formDateCash = now()->format('Y-m-d');
                $this->formDateInvoice = $cashEdit->invoice->invoice_date;

                $this->description = $cashEdit->invoice->description;
                $this->dueDollar = $cashEdit->invoice->due_dollar;
                $this->grandTotalDollar = $cashEdit->invoice->grand_total_dollar;
                $this->dueIraqi = $cashEdit->invoice->due_iraqi;
                $this->grandTotalIraqi = $cashEdit->invoice->grand_total_iraqi;

                $this->selectNotAttached = $cashEdit->invoice->id;
                $this->note = $cashEdit->invoice->notes;

                $this->initializePaymentEditArray($cashEdit->invoice ?? null, $cashEdit->id);
            } else {
                return redirect()->to('own/cash');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT INVOICE

    public function updateCash(){
        try {
            $validatedData = $this->validate();

            if($validatedData['dueDollar'] == 0) {
                $this->cash_status = 'Complete';
            } else {
                $this->cash_status = 'Not Complete';
            }

            Cash::where('id', $this->cashUpdate)->update([
                'payments' => json_encode($validatedData['arr_tasks']),
                'grand_total_dollar' => $validatedData['grandTotalDollar'],
                'due_dollar' => $validatedData['dueDollar'],
                'grand_total_iraqi' => $validatedData['grandTotalIraqi'],
                'due_iraqi' => $validatedData['dueIraqi'],
                'cash_status' => $this->cash_status,
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramCashNew(
                        $this->cashUpdate,
                        $validatedData['formDateCash'],
                        $this->selectNotAttached,
                        $validatedData['arr_tasks'],
                        $validatedData['dueDollar'],
                        $validatedData['dueIraqi'],
                        $validatedData['grandTotalDollar'],
                        $validatedData['grandTotalIraqi'],

                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Cash Receipt Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE INVOICE

    public function deleteCash(int $selected_cash_id){
        $this->del_cash_id = $selected_cash_id;
        $this->del_cash_data = Cash::find($this->del_cash_id);
        if($this->del_cash_data){
            // $this->del_invoice_name = $this->del_invoice_data->invoice_name;
            $this->del_cash_name = 'delete';
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE INVOICE

    public function destroyCash(){
        if ($this->confirmDelete && $this->cash_name_to_selete === $this->del_cash_name) {

            Cash::find($this->del_cash_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramCashDelete(
                        $this->del_cash_id,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            
            $this->del_cash_id = null;
            $this->del_cash_data = null;
            $this->del_cash_name = null;
            $this->cash_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_cash_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->formDate = '';
        $this->clientName = '';
        $this->clientEmail = '';
        $this->clientCountry = '';
        $this->clientCity = '';
        $this->clientAddress = '';
        $this->clientPhoneOne = '';
        $this->clientPhoneTwo = '';
        $this->actionFlag = true;
        $this->arr_tasks = [];
        $this->description = '';
        $this->note = null;
        $this->dueDollar = null;
        $this->grandTotalDollar = null;
        $this->dueIraqi = null;
        $this->grandTotalIraqi = null;

        $this->initializePaymentArray(null);
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal() {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public function resetFilter(){
        $this->search = null;
        $this->invoiceId= null;
        $this->CashDueFilter = '';
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
                $query->whereHas('invoice.client', function ($subQuery) {
                    $subQuery->where('client_name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('invoice', function ($subQuery) {
                    $subQuery->where('description', 'like', '%' . $this->search . '%');
                })
                ->orWhere('invoice_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('invoice.invoice_date', [$this->startDate, $this->endDate]);
            })
            ->orderBy('progress', 'ASC')
            ->paginate(15);
        // $colspan = 9;
        // $cols_th = ['#', 'Invoice ID', 'User ID', 'Task ID', 'Start Date', 'End Date', 'Progress', 'Task Status', 'Status', 'Actions'];
        // $cols_td = ['id', 'invoice.id', 'user.name', 'task.task_option', 'start_date', 'end_date', 'progress', 'task_status', 'status'];
        
        // $data = EmpTask::with(['user', 'invoice', 'task'])
        //     ->when($this->search, function ($query) {
        //         $query->whereHas('invoice.client', function ($subQuery) {
        //             $subQuery->where('client_name', 'like', '%' . $this->search . '%');
        //         })
        //         ->orWhereHas('invoice', function ($subQuery) {
        //             $subQuery->where('description', 'like', '%' . $this->search . '%');
        //         })
        //         ->orWhere('invoice_id', 'like', '%' . $this->search . '%');
        //     })
        //     ->when($this->startDate && $this->endDate, function ($query) {
        //         $query->whereBetween('start_date', [$this->startDate, $this->endDate]);
        //     })
        //     ->orderBy('progress', 'ASC')
        //     ->paginate(15);
        
    // dd($data);
        
        return view('livewire.own.emp-task-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}
