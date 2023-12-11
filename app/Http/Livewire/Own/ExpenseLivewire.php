<?php

namespace App\Http\Livewire\Own;

use App\Models\User;
use App\Models\Expense;
use App\Models\Profile;
use Livewire\Component;
use App\Models\BillsExpense;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramExpenseNew;
use App\Notifications\Own\TelegramExpenseUpdate;
use App\Notifications\Own\TelegramExpenseShort;
use App\Notifications\Own\TelegramExpenseDelete;

class ExpenseLivewire extends Component
{
    use WithPagination; 
    // use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    // FORM BILL TYPE
    public $bill_data;
    public $select_bill_data;
    public $billName;
    // FORM emp TYPE
    public $user_data;
    public $select_user_data;
    public $empName;
    // FORM emp TYPE
    public $expenseOtherName;
    // GENERAL INFORMATION
    public $cost_dollar;
    public $cost_iraqi;
    public $description;
    public $billDate;
    public $status;
    //FILTERS
    public $search;
    public $dateRange = null;
    public $rangeViewValue = null;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $userUpdate;
    public $old_user_data;
    public $del_expense_id;
    public $del_expense_data;
    public $del_expense_name;
    public $expense_name_to_selete;
    public $confirmDelete = false;

    protected $listeners = ['dateRangeSelected' => 'applyDateRangeFilter'];


    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
        $this->confirmDelete = false;
    } // END FUNCTION OF PAGE LOAD

    // protected function rules()
    // {
    //     $rules = [];
    //     return $rules;
    // } // END FUNCTION OF Rules

    // *********************
    // START - FOR THE BILLS PROCESS
    // *********************
    // Add Section
    public function addExpenseBillModalStartup(){
        $this->resetModal();
        $this->bill_data = BillsExpense::get();
    }
    public function selectExpenseBillModalStartup(){
        $this->resetModal();
        $this->select_bill_data;

        $selected_by_user_bill_data = BillsExpense::where('id', $this->select_bill_data)->first();
        $this->billName = $selected_by_user_bill_data->bill_name;
        $this->cost_dollar = $selected_by_user_bill_data->cost_dollar;
        $this->cost_iraqi = $selected_by_user_bill_data->cost_iraqi;
        $this->description = $selected_by_user_bill_data->description;
        $this->status = $selected_by_user_bill_data->status;
    }
    public function addBillExpense(){
        try {
            $bill_expense = Expense::create([
                'item' => $this->billName,
                'type' => 'Bill',
                'description' => $this->description,
                'cost_dollar' => $this->cost_dollar,
                'cost_iraqi' => $this->cost_iraqi,
                'payed_date' => $this->billDate,
                'status' => $this->status
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramExpenseNew(
                        $bill_expense->id,
                        $this->billName,
                        'Bill',
                        $this->cost_dollar,
                        $this->cost_iraqi,
                        $this->billDate,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Expense Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }
    // *********************
    // END - FOR THE BILLS PROCESS
    // *********************

    // *********************
    // START - FOR THE EMP PROCESS
    // *********************
    public function addExpenseEmpModalStartup(){
        $this->resetModal();
        $this->user_data = User::get();
    }
    public function selectExpenseEmpModalStartup(){
        $this->resetModal();
        $this->select_user_data;

        $selected_by_user_user_data = User::where('id', $this->select_user_data)->first();
        $this->empName = $selected_by_user_user_data->name;
        $this->cost_dollar = $selected_by_user_user_data->profile->salary_dollar;
        $this->cost_iraqi = $selected_by_user_user_data->profile->salary_iraqi;
        $this->description = $selected_by_user_user_data->profile->job_title;
        $this->status = $selected_by_user_user_data->profile->status;
    }
    public function addEmpExpense(){
        try {
            $emp_expense = Expense::create([
                'item' => $this->empName,
                'type' => 'Salary',
                'description' => $this->description,
                'cost_dollar' => $this->cost_dollar,
                'cost_iraqi' => $this->cost_iraqi,
                'payed_date' => $this->billDate,
                'status' => $this->status
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramExpenseNew(
                        $emp_expense->id,
                        $this->empName,
                        'Salary',
                        $this->cost_dollar,
                        $this->cost_iraqi,
                        $this->billDate,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Expense Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }
    // *********************
    // END - FOR THE EMP PROCESS
    // *********************

        // *********************
    // START - FOR THE EMP PROCESS
    // *********************
    public function selectExpenseOthModalStartup(){
        $this->resetModal();
    }
    public function addOtherExpense(){
        try {
            $other_expense = Expense::create([
                'item' => $this->expenseOtherName,
                'type' => 'Other',
                'description' => $this->description,
                'cost_dollar' => $this->cost_dollar,
                'cost_iraqi' => $this->cost_iraqi,
                'payed_date' => $this->billDate,
                'status' => $this->status
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramExpenseNew(
                        $other_expense->id,
                        $this->expenseOtherName,
                        'Other',
                        $this->cost_dollar,
                        $this->cost_iraqi,
                        $this->billDate,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Expense Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }
    // *********************
    // END - FOR THE EMP PROCESS
    // *********************




    public $gName;
    public $type;
    public $expenseUpdate;
    public $old_expense_data;
    // Edit Section
    public function editExpenseBillModalStartup(int $expenseId){
        $this->resetModal();
        try {
            $expenseEdit = Expense::find($expenseId);
            // dd($expenseEdit);
            $this->expenseUpdate = $expenseId;
            $this->old_expense_data = [];
            if ($expenseEdit) {
                if($expenseEdit->type == "Bill") {
                    $this->old_expense_data = null;
                    $this->gName = $expenseEdit->item;
                    $this->type = $expenseEdit->type;
                    $this->cost_dollar = $expenseEdit->cost_dollar;
                    $this->cost_iraqi = $expenseEdit->cost_iraqi;
                    $this->description = $expenseEdit->description;
                    $this->billDate = $expenseEdit->payed_date;
                    $this->status = $expenseEdit->status;
                } else if ($expenseEdit->type == "Salary") {
                    $this->old_expense_data = null;
                    $this->gName = $expenseEdit->item;
                    $this->type = $expenseEdit->type;
                    $this->cost_dollar = $expenseEdit->cost_dollar;
                    $this->cost_iraqi = $expenseEdit->cost_iraqi;
                    $this->description = $expenseEdit->description;
                    $this->billDate = $expenseEdit->payed_date;
                    $this->status = $expenseEdit->status;
                } else {
                    $this->old_expense_data = null;
                    $this->gName = $expenseEdit->item;
                    $this->type = $expenseEdit->type;
                    $this->cost_dollar = $expenseEdit->cost_dollar;
                    $this->cost_iraqi = $expenseEdit->cost_iraqi;
                    $this->description = $expenseEdit->description;
                    $this->billDate = $expenseEdit->payed_date;
                    $this->status = $expenseEdit->status;
                }
                $this->old_expense_data = [
                    'id' => $expenseEdit->id,
                    'item' => $expenseEdit->item,
                    'type' => $expenseEdit->type,
                    'cost_dollar' => $expenseEdit->cost_dollar,
                    'cost_iraqi' => $expenseEdit->cost_iraqi,
                    'description' => $expenseEdit->description,
                    'billDate' => $expenseEdit->payed_date,
                    'status' => $expenseEdit->status
                ];
            } else {
                return redirect()->to('own/expense');
            }
        } catch (\Exception $e){

        }
    }
    public function updateExpenseBillModalStartup(){
        $this->resetModal();
        $this->select_bill_data = $this->expenseUpdate;

        try {
            // if( $this->type == "Bill" ) {
                Expense::where('id', $this->select_bill_data)->update([
                    'item' => $this->gName,
                    'type' => $this->type,
                    'description' => $this->description,
                    'cost_dollar' => $this->cost_dollar,
                    'cost_iraqi' => $this->cost_iraqi,
                    'payed_date' => $this->billDate,
                    'status' => $this->status
                ]);
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramExpenseUpdate(
                        $this->select_bill_data,
                        $this->gName,
                        $this->type,
                        $this->description,
                        $this->cost_dollar,
                        $this->cost_iraqi,
                        $this->billDate,
                        $this->status,

                        $this->old_expense_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Service Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }
    // Delete Section

    public function updateStatus(int $expense_Id) {
        $itemState = Expense::find($expense_Id);
        // Toggle the status (0 to 1 and 1 to 0)
        $this->old_expense_data = [
            'status' => $itemState->status
        ];

        $itemState->status = $itemState->status == 0 ? 1 : 0;

        if($this->telegram_channel_status == 1){
            try{
                Notification::route('toTelegram', null)
                ->notify(new TelegramExpenseShort(
                    $expense_Id,
                    $itemState->item,
                    $itemState->status,

                    $this->old_expense_data,
                    $this->tele_id,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $itemState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Expense Status Updated Successfully')]);
    } // END FUNCTION OF UPDATING PRIOEITY

    public function deleteExpense(int $selected_expense_id){
        $this->del_expense_id = $selected_expense_id;
        $this->del_expense_data = Expense::find($this->del_expense_id);
        if($this->del_expense_data->item){
            $this->del_expense_name = $this->del_expense_data->item ?? "Delete";
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE CLIENT

    public function destroyExpense(){
        if ($this->confirmDelete && $this->expense_name_to_selete === $this->del_expense_name) {
            Expense::find($this->del_expense_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramExpenseDelete(
                        $this->del_expense_id,
                        $this->del_expense_data->item,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_expense_id = null;
            $this->del_expense_data = null;
            $this->del_expense_name = null;
            $this->expense_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('User Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_expense_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->bill_data = '';
        $this->select_bill_data = '';
        $this->billName = '';
        $this->user_data = '';
        $this->select_user_data = '';
        $this->empName = '';
        $this->expenseOtherName = '';
        $this->status = 1;
        $this->cost_dollar = '';
        $this->cost_iraqi = '';
        $this->description = '';
        $this->billDate = '';
        $this->del_expense_id = null;
        $this->del_expense_data = null;
        $this->del_expense_name = null;
    } // END FUNCTION OF RESET VARIABLES

    public function resetFilter(){
        $this->search = null;
        $this->dateRange = null;
        $this->rangeViewValue = null;
    }


    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public $startDate ;
    public $endDate ;    

    public function applyDateRangeFilter()
    {
        // return $this->dateRange;
    }


    public function render()
    {
        if ($this->dateRange) {
            list($this->startDate, $this->endDate) = explode(' - ', $this->dateRange);
        }

        $this->rangeViewValue = $this->startDate . ' - ' . $this->endDate . ' ';

        $colspan = 6;
        $cols_th = ['#','Item','Type Expense', 'Price in ($)','Price in (IQD)', 'Note', 'Date','Status','Actions'];
        $cols_td = ['id','item','type','cost_dollar','cost_iraqi','description','payed_date','status'];

        $data = Expense::query()
        ->where(function ($query) {
            $query->where('item', 'like', '%' . $this->search . '%')
                ->orWhere('type', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('cost_dollar', 'like', '%' . $this->search . '%')
                ->orWhere('cost_iraqi', 'like', '%' . $this->search . '%');
        })
        ->when($this->startDate && $this->endDate, function ($query) {
            $query->whereBetween('payed_date', [$this->startDate, $this->endDate]);
        })
        ->orderBy('payed_date', 'DESC')
        ->paginate(15);
        
        return view('livewire.own.expense-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'rangeViewValue' => $this->rangeViewValue,
        ]);
    } // END FUNCTION OF RENDER
}