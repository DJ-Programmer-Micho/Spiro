<?php

namespace App\Http\Livewire\Own;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramPaymentNew;
use App\Notifications\Own\TelegramPaymentUpdate;
use App\Notifications\Own\TelegramPaymentDelete;

class PaymentLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    //FORM
    public $paymentType;
    public $status;
    //FILTERS
    public $search;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $paymentUpdate;
    public $old_payment_data;
    public $del_payment_id;
    public $del_payment_data;
    public $del_payment_name;
    public $payment_name_to_selete;
    public $confirmDelete = false;

    public function mount(){
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
    } // END FUNCTION OF PAGE LOAD

    protected function rules()
    {
        $rules = [];
        $rules['paymentType'] = ['required'];
        $rules['status'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addPayment(){
        try {
            $validatedData = $this->validate();

            $payment = Payment::create([
                'payment_type' => $validatedData['paymentType'],
                'status' => $validatedData['status']
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramPaymentNew(
                        $payment->id,
                        $validatedData['paymentType'],
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Payment Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF ADD CLIENT

    public function editPayment(int $paymentId){
        try {
            $paymentEdit = Payment::find($paymentId);
            $this->paymentUpdate = $paymentId;
            $this->old_payment_data = [];

            if ($paymentEdit) {
                $this->old_payment_data = null;
                $this->paymentType = $paymentEdit->payment_type;
                $this->status = $paymentEdit->status;

                $this->old_payment_data = [
                    'id' => $paymentEdit->id,
                    'paymentType' => $paymentEdit->payment_type,
                    'status' => $paymentEdit->status,
                ];
            } else {
                return redirect()->to('own/payment');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT CLIENT

    public function updatePayment(){
        try {
            $validatedData = $this->validate();

            Payment::where('id', $this->paymentUpdate)->update([
                'payment_type' => $validatedData['paymentType'],
                'status' => $validatedData['status'],
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramPaymentUpdate(
                        $this->paymentUpdate,
                        $validatedData['paymentType'],
                        $validatedData['status'],

                        $this->old_payment_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Payment Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE CLIENT

    public function deletePayment(int $selected_payment_id){
        $this->del_payment_id = $selected_payment_id;
        $this->del_payment_data = Payment::find($this->del_payment_id);
        if($this->del_payment_data->payment_type){
            $this->del_payment_name = $this->del_payment_data->payment_type;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE CLIENT

    public function destroyPayment(){
        if ($this->confirmDelete && $this->payment_name_to_selete === $this->del_payment_name) {
            Payment::find($this->del_payment_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramPaymentDelete(
                        $this->del_payment_id,
                        $this->del_payment_data->payment_type,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_payment_id = null;
            $this->del_payment_data = null;
            $this->del_payment_name = null;
            $this->payment_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_payment_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->paymentType = '';
        $this->status = '';

        $this->del_payment_id = null;
        $this->del_payment_data = null;
        $this->del_payment_name = null;
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL


    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','Payment Type', 'Status', 'Actions'];
        $cols_td = ['id','payment_type','status'];

        $data = Payment::query()
        ->where(function ($query) {
            $query->where('payment_type', 'like', '%' . $this->search . '%')
                // ->orWhere('service_name', 'like', '%' . $this->search . '%')
                ;
        })
        // ->orderBy('priority', 'ASC')
        ->paginate(15);
        
        return view('livewire.own.payment-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}