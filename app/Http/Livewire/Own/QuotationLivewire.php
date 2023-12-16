<?php

namespace App\Http\Livewire\Own;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Service;
use Livewire\Component;
use App\Models\Quotation;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramQuotationNew;
use App\Notifications\Own\TelegramQuotationUpdate;
use App\Notifications\Own\TelegramServiceDelete;

class QuotationLivewire extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap';

    // Form Date Section
    public $formDate;
    public $status;
    public $quotation_status;
    // 'sent', 'approved', 'rejected'
    // Form Client Section
    public $client_data;
    public $select_client_data;
    public $clientName;
    public $clientEmail;
    public $clientCountry;
    public $clientCity;
    public $clientAddress;
    public $clientPhoneOne;
    public $clientPhoneTwo;
    // Form Payment Section
    public $payment_data;
    public $select_payment_data;
    public $paymentType;
    public $exchange_rate = 0;
    // Form service Section
    public $service_data;
    public $select_service_data;
    public $arr_service = [];
    // Form Final Section
    public $description;
    public $note = [];
    public $totalDollar;
    public $taxDollar;
    public $discountDollar;
    public $fisrtPayDollar;
    public $dueDollar;
    public $grandTotalDollar;
    public $totalIraqi;
    public $taxIraqi;
    public $discountIraqi;
    public $fisrtPayIraqi;
    public $dueIraqi;
    public $grandTotalIraqi;
    //FILTERS
    public $search;
    public $dateRange = null;
    public $rangeViewValue = null;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $quotationUpdate;
    public $old_quotation_data;
    public $del_quotation_id;
    public $del_quotation_data;
    public $del_quotation_name;
    public $quotation_name_to_selete;
    public $confirmDelete = false;

    public function mount() {
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
        $this->client_data = Client::get();
        $this->payment_data = Payment::get();
        $this->service_data = Service::get();
        $this->quotation_status = 'Sent';
        $this->initializeServicesArray();
    } // END FUNCTION OF PAGE LOAD

    public function initializeServicesArray() {
        $this->arr_service = [];
        for ($i = 0; $i < 3; $i++) {
            $this->arr_service[] = [
                'serviceCode' => '',
                'select_service_data' => null,
                'serviceDescription' => '',
                'serviceDefaultCostDollar' => 0,
                'serviceDefaultCostIraqi' => 0,
                'serviceQty' => 0,
                'serviceTotalDollar' => 0,
                'serviceTotalIraqi' => 0,
            ];
        }
    } //END FUNCTION OF INITIALIZE

    public function newRecService() {
        $this->arr_service[] = [
            'serviceCode' => '',
            'select_service_data' => null,
            'serviceDescription' => '',
            'serviceDefaultCostDollar' => 0,
            'serviceDefaultCostIraqi' => 0,
            'serviceQty' => 0,
            'serviceTotalDollar' => 0,
            'serviceTotalIraqi' => 0,
        ];
    } // END FUNCTION OF ADD NEW SERVICE

    public function removeService($index) {
        unset($this->arr_service[$index]);
        $this->arr_service = array_values($this->arr_service); // Reset array keys
    } // END FUNCTION OF ADD DELETE SERVICE


    public $showTextarea = 1;
    public function serviceQtyChange($index) {
        $this->arr_service[$index]['serviceTotalDollar'] =
            $this->arr_service[$index]['serviceDefaultCostDollar'] * $this->arr_service[$index]['serviceQty'];


        $this->arr_service[$index]['serviceDefaultCostIraqi'] = $this->arr_service[$index]['serviceDefaultCostDollar'] * $this->exchange_rate;

        $this->arr_service[$index]['serviceTotalIraqi'] =
            $this->arr_service[$index]['serviceDefaultCostIraqi'] * $this->arr_service[$index]['serviceQty'];

        $this->calculateTotals();
    }

    public function selectServiceDataChange($index) {
        $selectedService = Service::find($this->arr_service[$index]['select_service_data']);
        if ($selectedService) {
            $this->arr_service[$index]['serviceCode'] = $selectedService->service_code;
            $this->arr_service[$index]['serviceDescription'] = $selectedService->service_description;
            $this->arr_service[$index]['serviceDefaultCostDollar'] = $selectedService->price_dollar;
            
            $this->arr_service[$index]['serviceDefaultCostIraqi'] = $selectedService->price_dollar * $this->exchange_rate;
            // $this->arr_service[$index]['serviceDefaultCostIraqi'] = $selectedService->price_iraqi;

            $this->calculateTotals();
        }
    }

    public function updatedDiscount() {
        $this->calculateTotals();
    }

    public function updatedFisrtPay() {
        $this->calculateTotals();
    }


    public function calculateTotals() {
        $totalDollar = 0;
  
        foreach ($this->arr_service as $service) {
            $totalDollar += $service['serviceTotalDollar'];
        }

        $this->totalDollar = $totalDollar;
        $this->grandTotalDollar = $totalDollar - $this->discountDollar + $this->taxDollar;
        $this->dueDollar = $this->grandTotalDollar - $this->fisrtPayDollar; 

        // foreach ($this->arr_service as $service) {
        //     $totalIraqi += $service['serviceTotalIraqi'];
        // }

        // $this->totalIraqi = $totalIraqi;
        $this->totalIraqi = $totalDollar * $this->exchange_rate;
        $this->discountIraqi = $this->discountDollar * $this->exchange_rate;
        $this->taxIraqi = $this->taxDollar * $this->exchange_rate;
        $this->fisrtPayIraqi = $this->fisrtPayDollar * $this->exchange_rate;
        
        $this->grandTotalIraqi = $this->taxIraqi + ($this->totalIraqi - $this->discountIraqi);
        $this->dueIraqi = $this->grandTotalIraqi - $this->fisrtPayIraqi;
    }

    public function exchangeUpdate(){
        foreach ($this->arr_service as $index => $service) {
            $selectedService = Service::find($service['select_service_data']);
            if ($selectedService) {
                $this->arr_service[$index]['serviceDefaultCostIraqi'] = $selectedService->price_dollar * $this->exchange_rate;
            }
            $this->serviceQtyChange($index);
        }
        $this->calculateTotals();
    }

    // public function updateAllDefaultCosts() {
    //     $this->updateDefaultCosts();
    // }

    public function selectClientStartup(){
        $client_selected = Client::where('id', $this->select_client_data)->first();
        $this->clientName = $client_selected->client_name;
        $this->clientEmail = $client_selected->email;
        $this->clientCountry = $client_selected->country;
        $this->clientCity = $client_selected->city;
        $this->clientAddress = $client_selected->address;
        $this->clientPhoneOne = $client_selected->phone_one;
        $this->clientPhoneTwo = $client_selected->phone_two;
    }

    public function selectPaymentStartup(){
        $payment_selected = Payment::where('id', $this->select_payment_data)->first();
        $this->paymentType = $payment_selected->payment_type;
    }

    protected function rules() {
        $rules = [];
        $rules['formDate'] = ['required'];
        $rules['status'] = ['required'];
        $rules['quotation_status'] = ['required'];
        $rules['status'] = ['required'];
        $rules['select_client_data'] = ['required'];
        $rules['select_payment_data'] = ['required'];
        $rules['arr_service'] = ['required'];
        $rules['totalDollar'] = ['required'];
        $rules['taxDollar'] = ['required'];
        $rules['discountDollar'] = ['required'];
        $rules['fisrtPayDollar'] = ['required'];
        $rules['dueDollar'] = ['required'];
        $rules['grandTotalDollar'] = ['required'];
        $rules['totalIraqi'] = ['required'];
        $rules['taxIraqi'] = ['required'];
        $rules['discountIraqi'] = ['required'];
        $rules['fisrtPayIraqi'] = ['required'];
        $rules['dueIraqi'] = ['required'];
        $rules['grandTotalIraqi'] = ['required'];
        return $rules;
    } // END FUNCTION OF Rules

    public function addQuotation(){
        try {
            $validatedData = $this->validate();

            $quotation = Quotation::create([
                'client_id' => $validatedData['select_client_data'],
                'payment_id' => $validatedData['select_payment_data'],
                'exchange_rate' => $this->exchange_rate,
                'qoutation_date' => $validatedData['formDate'],
                'status' => $validatedData['status'],
                'quotation_status' => $validatedData['quotation_status'],
                'status' => $validatedData['status'],
                'services' => json_encode($validatedData['arr_service']),
                'total_amount_dollar' => $validatedData['totalDollar'],
                'tax_dollar' => $validatedData['taxDollar'],
                'discoun_dollart' => $validatedData['discountDollar'],
                'first_pay_dollar' => $validatedData['fisrtPayDollar'],
                'due_dollar' => $validatedData['dueDollar'],
                'grand_total_dollar' => $validatedData['grandTotalDollar'],
                'total_amount_iraqi' => $validatedData['totalIraqi'],
                'tax_iraqi' => $validatedData['taxIraqi'],
                'discount_iraqi' => $validatedData['discountIraqi'],
                'first_pay_iraqi' => $validatedData['fisrtPayIraqi'],
                'due_iraqi' => $validatedData['dueIraqi'],
                'grand_total_iraqi' => $validatedData['grandTotalIraqi'],
                'description' => $this->description,
                'notes' => json_encode($this->note),
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramQuotationNew(
                        $quotation->id,
                        $validatedData['formDate'],
                        $validatedData['select_client_data'],
                        $validatedData['select_payment_data'],
                        $this->description ?? null,
                        $this->exchange_rate,
                        $validatedData['arr_service'],
                        $validatedData['taxDollar'],
                        $validatedData['discountDollar'],
                        $validatedData['fisrtPayDollar'],
                        $validatedData['dueDollar'],
                        $validatedData['taxIraqi'],
                        $validatedData['discountIraqi'],
                        $validatedData['fisrtPayIraqi'],
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

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Quotation Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }

    public function editQuotation(int $quotationId){
        try {
            $quotationEdit = Quotation::find($quotationId);
            $this->quotationUpdate = $quotationId;

            $clientInfo = Client::find($quotationEdit->client_id);
            $paymentInfo = Payment::find($quotationEdit->payment_id);
            $this->old_quotation_data = [];

            if ($quotationEdit) {
                $this->old_quotation_data = null;
                // Quotation Date
                $this->formDate = $quotationEdit->qoutation_date;
                $this->status = $quotationEdit->status;
                $this->quotation_status = $quotationEdit->quotation_status;
                // Client Information
                $this->select_client_data =  $quotationEdit->client_id;
                $this->clientName = $clientInfo->client_name;
                $this->clientEmail = $clientInfo->country;
                $this->clientCountry = $clientInfo->city;
                $this->clientCity = $clientInfo->address;
                $this->clientAddress = $clientInfo->email;
                $this->clientPhoneOne = $clientInfo->phone_one;
                $this->clientPhoneTwo = $clientInfo->phone_two;
                // Payment Method
                $this->select_payment_data = $quotationEdit->payment_id;
                $this->exchange_rate = $quotationEdit->exchange_rate;
                // Service Section
                $this->description = $quotationEdit->description;
                $this->arr_service = json_decode($quotationEdit->services);
                // final Section
                $this->note = json_decode($quotationEdit->notes, true) ?? [];
                $this->totalDollar = $quotationEdit->total_amount_dollar;
                $this->taxDollar = $quotationEdit->tax_dollar;
                $this->discountDollar = $quotationEdit->discount_dollar;
                $this->fisrtPayDollar = $quotationEdit->first_pay_dollar;
                $this->dueDollar = $quotationEdit->due_dollar;
                $this->grandTotalDollar = $quotationEdit->grand_total_dollar;
                $this->totalIraqi = $quotationEdit->total_amount_iraqi;
                $this->taxIraqi = $quotationEdit->tax_iraqi;
                $this->discountIraqi = $quotationEdit->discount_iraqi;
                $this->fisrtPayIraqi = $quotationEdit->first_pay_iraqi;
                $this->dueIraqi = $quotationEdit->due_iraqi;
                $this->grandTotalIraqi = $quotationEdit->grand_total_iraqi;

                $this->old_quotation_data = [
                    // Quotation Date
                    'formDate' => $quotationEdit->qoutation_date,
                    'status' => $quotationEdit->status,
                    'quotation_status' => $quotationEdit->quotation_status,
                    // Client Information
                    'select_client_data' =>  $quotationEdit->client_id,
                    'clientName' => $clientInfo->client_name,
                    'clientEmail' => $clientInfo->country,
                    'clientCountry' => $clientInfo->city,
                    'clientCity' => $clientInfo->address,
                    'clientAddress' => $clientInfo->email,
                    'clientPhoneOne' => $clientInfo->phone_one,
                    'clientPhoneTwo' => $clientInfo->phone_two,
                    // Payment Method
                    'select_payment_data' => $quotationEdit->payment_id,
                    'payment_type' => $paymentInfo->payment_type,
                    'exchange_rate' => $quotationEdit->exchange_rate,
                    // Service Section
                    'description' => $quotationEdit->description,
                    'arr_service' => json_encode($quotationEdit->services),
                    // final Section
                    'note' => json_decode($quotationEdit->notes, true) ?? [],
                    'totalDollar' => $quotationEdit->total_amount_dollar,
                    'taxDollar' => $quotationEdit->tax_dollar,
                    'discountDollar' => $quotationEdit->discount_dollar,
                    'fisrtPayDollar' => $quotationEdit->first_pay_dollar,
                    'dueDollar' => $quotationEdit->due_dollar,
                    'grandTotalDollar' => $quotationEdit->grand_total_dollar,
                    'totalIraqi' => $quotationEdit->total_amount_iraqi,
                    'taxIraqi' => $quotationEdit->tax_iraqi,
                    'discountIraqi' => $quotationEdit->discount_iraqi,
                    'fisrtPayIraqi' => $quotationEdit->first_pay_iraqi,
                    'dueIraqi' => $quotationEdit->due_iraqi,
                    'grandTotalIraqi' => $quotationEdit->grand_total_iraqi,
                ];
            } else {
                return redirect()->to('own/quotation');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT CLIENT

    public function updateQuotation(){
        // try {
            $validatedData = $this->validate();

            Quotation::where('id', $this->quotationUpdate)->update([
                'client_id' => $validatedData['select_client_data'],
                'payment_id' => $validatedData['select_payment_data'],
                'exchange_rate' => $this->exchange_rate,
                'qoutation_date' => $validatedData['formDate'],
                'status' => $validatedData['status'],
                'quotation_status' => $validatedData['quotation_status'],
                'status' => $validatedData['status'],
                'services' => json_encode($validatedData['arr_service']),
                'total_amount_dollar' => $validatedData['totalDollar'],
                'tax_dollar' => $validatedData['taxDollar'],
                'discount_dollar' => $validatedData['discountDollar'],
                'first_pay_dollar' => $validatedData['fisrtPayDollar'],
                'due_dollar' => $validatedData['dueDollar'],
                'grand_total_dollar' => $validatedData['grandTotalDollar'],
                'total_amount_iraqi' => $validatedData['totalIraqi'],
                'tax_iraqi' => $validatedData['taxIraqi'],
                'discount_iraqi' => $validatedData['discountIraqi'],
                'first_pay_iraqi' => $validatedData['fisrtPayIraqi'],
                'due_iraqi' => $validatedData['dueIraqi'],
                'grand_total_iraqi' => $validatedData['grandTotalIraqi'],
                'description' => $this->description,
                'notes' => json_encode($this->note),
            ]);

            if($this->telegram_channel_status == 1){
                // try{

                    if ( $validatedData['select_client_data']) {
                        $client = Client::find( $validatedData['select_client_data']);
            
                        if ($client) {
                            $clientName = $client->client_name;
                        } else {
                            $clientName = 'Unknown Client';
                        }
                    } else {
                        $clientName = 'Invalid Client ID';
                    }
            
                    // Handling for $paymentId
                    if ($validatedData['select_payment_data']) {
                        $payment = Payment::find($validatedData['select_payment_data']);
            
                        if ($payment) {
                            $paymentType = $payment->payment_type;
                        } else {
                            $paymentType = 'Unknown Payment Type';
                        }
                    } else {
                        $paymentType = 'Invalid Payment ID';
                    }


                    Notification::route('toTelegram', null)
                    ->notify(new TelegramQuotationUpdate(
                        $this->quotationUpdate,
                        $validatedData['formDate'],
                        $clientName,
                        $paymentType,
                        $this->description ?? null,
                        $this->exchange_rate,
                        $validatedData['arr_service'],
                        $validatedData['taxDollar'],
                        $validatedData['discountDollar'],
                        $validatedData['fisrtPayDollar'],
                        $validatedData['dueDollar'],
                        $validatedData['taxIraqi'],
                        $validatedData['discountIraqi'],
                        $validatedData['fisrtPayIraqi'],
                        $validatedData['dueIraqi'],
                        $validatedData['grandTotalDollar'],
                        $validatedData['grandTotalIraqi'],

                        json_encode($this->note),
                        $validatedData['status'],
                        $validatedData['quotation_status'],

                        $this->old_quotation_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                // }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            // }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Service Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        // } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        // }
    } // END FUNCTION OF UPDATE CLIENT

    public function deleteService(int $selected_service_id){
        $this->del_service_id = $selected_service_id;
        $this->del_service_data = Service::find($this->del_service_id);
        if($this->del_service_data->service_name){
            $this->del_service_name = $this->del_service_data->service_name;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE CLIENT

    public function destroyService(){
        if ($this->confirmDelete && $this->service_name_to_selete === $this->del_service_name) {
            Service::find($this->del_service_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramServiceDelete(
                        $this->del_service_id,
                        $this->del_service_data->service_name,
                        $this->del_service_data->service_code,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_service_id = null;
            $this->del_service_data = null;
            $this->del_service_name = null;
            $this->service_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_service_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->formDate = '';
        $this->status = '';
        $this->quotation_status = 'Sent';
        $this->client_data = '';
        $this->select_client_data = '';
        $this->clientName = '';
        $this->clientEmail = '';
        $this->clientCountry = '';
        $this->clientCity = '';
        $this->clientAddress = '';
        $this->clientPhoneOne = '';
        $this->clientPhoneTwo = '';
        $this->payment_data = '';
        $this->select_payment_data = '';
        $this->paymentType = '';
        $this->service_data = '';
        $this->select_service_data = '';
        $this->arr_service = [];
        $this->description = '';
        $this->note = [];
        $this->totalDollar = '';
        $this->taxDollar = '';
        $this->discountDollar = '';
        $this->fisrtPayDollar = '';
        $this->dueDollar = '';
        $this->grandTotalDollar = '';
        $this->totalIraqi = '';
        $this->taxIraqi = '';
        $this->discountIraqi = '';
        $this->fisrtPayIraqi = '';
        $this->dueIraqi = '';
        $this->grandTotalIraqi = '';

        $this->client_data = Client::get();
        $this->payment_data = Payment::get();
        $this->service_data = Service::get();

        $this->initializeServicesArray();
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal()
    {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL


    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','Client Name', 'Payment Type', 'Description', 'Total', 'Grand Total', 'Quotation', 'Status','Date', 'Actions'];
        $cols_td = ['id','client.client_name','payment.payment_type','description','total_amount_dollar','grand_total_dollar','quotation_status','status','qoutation_date'];

        $data = Quotation::with(['client', 'payment'])
        ->where(function ($query) {
            $query->whereHas('client', function ($subQuery) {
                $subQuery->where('client_name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('payment', function ($subQuery) {
                $subQuery->where('payment_type', 'like', '%' . $this->search . '%');
            })
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('status', 'like', '%' . $this->search . '%');
        })
        ->orderBy('qoutation_date', 'DESC')
        ->paginate(15);
        
        return view('livewire.own.quotation-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}
// 716204