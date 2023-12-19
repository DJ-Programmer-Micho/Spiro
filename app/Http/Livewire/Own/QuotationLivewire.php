<?php

namespace App\Http\Livewire\Own;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use Livewire\Component;
use App\Models\Quotation;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramQuotationNew;
use App\Notifications\Own\TelegramQuotationUpdate;
use App\Notifications\Own\TelegramQuotationDelete;
use App\Notifications\Own\TelegramQuotationShort;
use App\Notifications\Own\TelegramInvoiceNew;
use App\Notifications\Own\TelegramClientNew;

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
    public $statusFilter = '';
    public $quotationStatusFilter = '';
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

    // Direct Forms Variables
    public $dClientName;
    public $country;
    public $city;
    public $address;
    public $email;
    public $phoneOne;
    public $phoneTwo;

    protected $listeners = ['dateRangeSelected' => 'applyDateRangeFilter'];

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

    public function addClientDirect(){
        try {
            // $validatedData = $this->validate();

            $client = Client::create([
                'client_name' => $this->dClientName,
                'email' => $this->email,
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
                'phone_one' => $this->phoneOne,
                'phone_two' => $this->phoneTwo,
            ]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramClientNew(
                        $client->id,
                        $this->dClientName,
                        $this->email,
                        $this->address,
                        $this->phoneOne,
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal-direct');
            $this->client_data = Client::get();
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }
    
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
        try {
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
                try{

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
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Quotation Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE CLIENT

    public function deleteQuotation(int $selected_quotation_id){
        $this->del_quotation_id = $selected_quotation_id;
        $this->del_quotation_data = Quotation::find($this->del_quotation_id);
        if($this->del_quotation_data){
            // $this->del_quotation_name = $this->del_quotation_data->quotation_name;
            $this->del_quotation_name = 'delete';
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE CLIENT

    public function destroyQuotation(){
        if ($this->confirmDelete && $this->quotation_name_to_selete === $this->del_quotation_name) {
            Quotation::find($this->del_quotation_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramQuotationDelete(
                        $this->del_quotation_id,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->del_quotation_id = null;
            $this->del_quotation_data = null;
            $this->del_quotation_name = null;
            $this->quotation_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_quotation_name]);
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
        $this->exchange_rate = 0;
        $this->totalDollar = 0;
        $this->taxDollar = 0;
        $this->discountDollar = 0;
        $this->fisrtPayDollar = 0;
        $this->dueDollar = 0;
        $this->grandTotalDollar = 0;
        $this->totalIraqi = 0;
        $this->taxIraqi = 0;
        $this->discountIraqi = 0;
        $this->fisrtPayIraqi = 0;
        $this->dueIraqi = 0;
        $this->grandTotalIraqi = 0;

        $this->client_data = Client::get();
        $this->payment_data = Payment::get();
        $this->service_data = Service::get();

        $this->initializeServicesArray();
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal() {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public function updateStatus(int $quotation_Id) {
        $itemState = Quotation::find($quotation_Id);
        // Toggle the status (0 to 1 and 1 to 0)
        $this->old_quotation_data = [
            'status' => $itemState->status
        ];

        $itemState->status = $itemState->status == 0 ? 1 : 0;

        if($this->telegram_channel_status == 1){
            try{

                if ( $itemState->client_id) {
                    $client = Client::find($itemState->client_id);
        
                    if ($client) {
                        $clientName = $client->client_name;
                    } else {
                        $clientName = 'Unknown Client';
                    }
                } else {
                    $clientName = 'Invalid Client ID';
                }


                Notification::route('toTelegram', null)
                ->notify(new TelegramQuotationShort(
                    $quotation_Id,
                    $clientName,
                    $itemState->status,
                    null,

                    $this->old_quotation_data,
                    $this->tele_id,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $itemState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Quotation Status Updated Successfully')]);
    } // END FUNCTION OF UPDATING PRIOEITY

    public function approved(int $quotation_Id) {
        //ADD NEW INVOICE
        try {
            $itemState = Quotation::find($quotation_Id);

            $invoice = Invoice::create([
                'quotation_id' => $itemState->id,
                'client_id' => $itemState->client_id,
                'payment_id' => $itemState->payment_id,
                'exchange_rate' => $itemState->exchange_rate,
                'invoice_date' => now()->format('Y-m-d'),
                'status' => $itemState->status,
                // 'services' => json_encode($itemState->arr_service),
                'services' => $itemState->services,
                'total_amount_dollar' => $itemState->total_amount_dollar,
                'tax_dollar' => $itemState->tax_dollar,
                'discoun_dollart' => $itemState->discount_dollar,
                'first_pay_dollar' => $itemState->first_pay_dollar,
                'due_dollar' => $itemState->due_dollar,
                'grand_total_dollar' => $itemState->grand_total_dollar,
                'total_amount_iraqi' => $itemState->total_amount_iraqi,
                'tax_iraqi' => $itemState->tax_iraqi,
                'discount_iraqi' => $itemState->discount_iraqi,
                'first_pay_iraqi' => $itemState->first_pay_iraqi,
                'due_iraqi' => $itemState->due_iraqi,
                'grand_total_iraqi' => $itemState->grand_total_iraqi,
                'description' => $itemState->description,
                'notes' => $itemState->note,
            ]);

            // Toggle the quotation status (sent -> approved)
            $this->old_quotation_data = [
                'quotation_status' => $itemState->quotation_status
            ];
            $itemState->quotation_status = 'Approved';
    
            if($this->telegram_channel_status == 1){
                try{
                    if ( $itemState->client_id) {
                        $client = Client::find($itemState->client_id);
            
                        if ($client) {
                            $clientName = $client->client_name;
                        } else {
                            $clientName = 'Unknown Client';
                        }
                    } else {
                        $clientName = 'Invalid Client ID';
                    }
    
            
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramQuotationShort(
                        $quotation_Id,
                        $clientName,
                        null,
                        $itemState->quotation_status,
    
                        $this->old_quotation_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
    
            $itemState->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Quotation Status Updated Successfully')]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramInvoiceNew(
                        $invoice->id,
                        now()->format('Y-m-d'),
                        $itemState->id,
                        $itemState->client_id,
                        $itemState->payment_id,
                        $itemState->description,
                        $itemState->exchange_rate,
                        json_decode($itemState->services, true),
                        $itemState->tax_dollar,
                        $itemState->discount_dollar,
                        $itemState->first_pay_dollar,
                        $itemState->due_dollar,
                        $itemState->tax_iraqi,
                        $itemState->discount_iraqi,
                        $itemState->first_pay_iraqi,
                        $itemState->due_iraqi,
                        $itemState->grand_total_dollar,
                        $itemState->grand_total_iraqi,
                        
                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Added To Invoice Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong OR Duplicated Quotation ID')]);
        }
    } // END FUNCTION OF UPDATING QUOTATION STATUS

    public function rejected(int $quotation_Id) {
        $itemState = Quotation::find($quotation_Id);

        $invoice = Invoice::where('quotation_id', $quotation_Id)->first() ?? null;
        if($invoice && $itemState->quotation_status == 'Approved') {
            Invoice::find($invoice->id)->delete();
        }


        // Toggle the status (0 to 1 and 1 to 0)
        $this->old_quotation_data = [
            'quotation_status' => $itemState->quotation_status
        ];
        $itemState->quotation_status = 'Rejected';

        if($this->telegram_channel_status == 1){
            try{
                if ( $itemState->client_id) {
                    $client = Client::find($itemState->client_id);
        
                    if ($client) {
                        $clientName = $client->client_name;
                    } else {
                        $clientName = 'Unknown Client';
                    }
                } else {
                    $clientName = 'Invalid Client ID';
                }


                Notification::route('toTelegram', null)
                ->notify(new TelegramQuotationShort(
                    $quotation_Id,
                    $clientName,
                    null,
                    $itemState->quotation_status,

                    $this->old_quotation_data,
                    $this->tele_id,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $itemState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Quotation Status Updated Successfully')]);
    } // END FUNCTION OF UPDATING QUOTATION STATUS

    public function resetFilter(){
        $this->search = null;
        $this->statusFilter = '';
        $this->quotationStatusFilter = '';
        $this->dateRange = null;
        $this->rangeViewValue = null;
        $this->startDate = null;
        $this->endDate = null;
    }

    public function applyDateRangeFilter() {
        // return $this->dateRange;
    }

    public $startDate ;
    public $endDate ; 
    public function render() {
        if ($this->dateRange) {
            list($this->startDate, $this->endDate) = explode(' - ', $this->dateRange);
        }

        $this->rangeViewValue = $this->startDate . ' - ' . $this->endDate . ' ';


        $colspan = 6;
        $cols_th = ['#','Client Name', 'Payment Type', 'Description', 'Total', 'Grand Total', 'Quotation', 'Status','Date','Created Date', 'Actions'];
        $cols_td = ['id','client.client_name','payment.payment_type','description','grand_total_dollar','grand_total_iraqi','quotation_status','status','qoutation_date','created_at'];

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
        ->when($this->startDate && $this->endDate, function ($query) {
            $query->whereBetween('qoutation_date', [$this->startDate, $this->endDate]);
        })
        ->when($this->quotationStatusFilter !== '', function ($query) {
            $query->where(function ($query) {
                $query->where('quotation_status', $this->quotationStatusFilter)
                    ->orWhereNull('quotation_status');
            });
        })
        ->when($this->statusFilter !== '', function ($query) {
            $query->where(function ($query) {
                $query->where('status', $this->statusFilter)
                    ->orWhereNull('status');
            });
        })
        // ->when($this->quotationStatusFilter === '', function ($query) {
        //     $query->orWhereNotNull('quotation_status');
        // })
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
