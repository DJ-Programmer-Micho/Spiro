<?php

namespace App\Http\Livewire\Fin;


use App\Models\BillsExpense;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Fin\TelegramBillNew;
use App\Notifications\Fin\TelegramBillUpdate;

class ExpenseBillLivewire extends Component
{
    use WithPagination; 
    // use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $billName;
    public $cost_dollar;
    public $cost_iraqi;
    public $description;
    public $status;
    //FILTERS
    public $search;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $billUpdate;
    public $old_bill_data;
    public $del_bill_id;
    public $del_bill_data;
    public $del_bill_name;
    public $bill_name_to_selete;
    public $confirmDelete = false;

    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
    } // END FUNCTION OF PAGE LOAD

    protected function rules()
    {
        $rules = [];
        $rules['billName'] = ['required'];
        $rules['cost_dollar'] = ['required'];
        $rules['cost_iraqi'] = ['required'];
        $rules['status'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addBill(){
        try {
            $validatedData = $this->validate();

            $bill = BillsExpense::create([
                'bill_name' => $validatedData['billName'],
                'description' => $this->description ?? null,
                'cost_dollar' => $validatedData['cost_dollar'],
                'cost_iraqi' => $validatedData['cost_iraqi'],
                'status' => $validatedData['status'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramBillNew(
                        auth()->user()->name,
                        $bill->id,
                        $validatedData['billName'],
                        $validatedData['cost_dollar'],
                        $validatedData['cost_iraqi'],
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Bill Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF ADD CLIENT
    public function editBill(int $billId){
        try {
            $billEdit = BillsExpense::find($billId);
            $this->billUpdate = $billId;
            $this->old_bill_data = [];

            if ($billEdit) {
                $this->old_bill_data = null;
                $this->billName = $billEdit->bill_name;
                $this->cost_dollar = $billEdit->cost_dollar;
                $this->cost_iraqi = $billEdit->cost_iraqi;
                $this->description = $billEdit->description;
                $this->status = $billEdit->status;

                $this->old_bill_data = [
                    'id' => $billEdit->id,
                    'billName' => $billEdit->bill_name,
                    'cost_dollar' => $billEdit->cost_dollar,
                    'cost_iraqi' => $billEdit->cost_iraqi,
                    'description' => $billEdit->description,
                    'status' => $billEdit->status
                ];
            } else {
                return redirect()->to('own/expense/bill');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT CLIENT

    public function updateBill(){
        try {
            $validatedData = $this->validate();

            BillsExpense::where('id', $this->billUpdate)->update([
                'bill_name' => $validatedData['billName'],
                'description' => $this->description ?? null,
                'cost_dollar' => $validatedData['cost_dollar'],
                'cost_iraqi' => $validatedData['cost_iraqi'],
                'status' => $validatedData['status'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramBillUpdate(
                        auth()->user()->name,
                        $this->billUpdate,
                        $this->billName,
                        $this->cost_dollar,
                        $this->cost_iraqi,
                        $this->description,
                        $this->status,
                        
                        $this->old_bill_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Bill Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE CLIENT

    public function deleteMessage(){
        $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => __('HA HA HA, Nice Try')]);
    } // END FUNCTION OF DELETE CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->billName = '';
        $this->cost_dollar = '';
        $this->cost_iraqi = '';
        $this->description = '';
        $this->status = '';
        $this->del_bill_id = null;
        $this->del_bill_data = null;
        $this->del_bill_name = null;
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL


    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','Item', 'Price in ($)','Price in (IQD)', 'Note', 'Status', 'Actions'];
        $cols_td = ['id','bill_name','cost_dollar','cost_iraqi','description','status'];

        $data = BillsExpense::query()
        ->where(function ($query) {
            $query->where('bill_name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('cost_dollar', 'like', '%' . $this->search . '%')
                ->orWhere('cost_iraqi', 'like', '%' . $this->search . '%');
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
        
        return view('livewire.fin.bill-expense-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}