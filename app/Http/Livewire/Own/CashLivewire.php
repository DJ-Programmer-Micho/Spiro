<?php

namespace App\Http\Livewire\Own;

use App\Models\Cash;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use Livewire\Component;
use App\Models\Quotation;
use Livewire\WithPagination;
// use App\Notifications\Own\TelegramInvoiceNew;
use App\Notifications\Own\TelegramCashNew;
use App\Notifications\Own\TelegramCashShort;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Own\TelegramCashDelete;
use App\Notifications\Own\TelegramCashUpdate;

class CashLivewire extends Component
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
    public $status;
    // Form Client Section
    public $clientId;
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
    public $formDateCash;
    public $formDateInvoice;
    // Form service Section
    public $service_data;
    public $select_service_data;
    public $arr_payments = [];
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
    public $invoiceStatusFilter = '';
    public $dateRange = null;
    public $rangeViewValue = null;
    //TELEGRAM
    public $tele_id;
    public $telegram_channel_status;
    //TEMP VARIABLES
    public $invoiceUpdate;
    public $old_invoice_data;
    public $del_invoice_id;
    public $del_invoice_data;
    public $del_invoice_name;
    public $invoice_name_to_selete;
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
        // $this->initializeServicesArray();

        $attachedInvoiceIds = Cash::pluck('invoice_id')->toArray();
        $notAttachedInvoices = Invoice::whereNotIn('id', $attachedInvoiceIds)->get();
        $this->notAttached = $notAttachedInvoices;
    } // END FUNCTION OF PAGE LOAD

    // public function initializeServicesArray() {
    //     $this->arr_payments = [];
    //     for ($i = 0; $i < 3; $i++) {
    //         $this->arr_payments[] = [
    //             'payment_date' => '',
    //             'paymentAmountDollar' => 0,
    //             'paymentAmountIraqi' => 0,
    //         ];
    //     }
    // } //END FUNCTION OF INITIALIZE

    public function initializeServicesArray($invoice) {
        $this->arr_payments = [];
    
        // Check if the invoice has a first payment
        $this->hasFirstPayment = $invoice && $invoice->first_pay_dollar != 0;
        // Initialize the array based on conditions
        if ($this->hasFirstPayment) {
            $this->arr_payments[] = [
                'payment_date' => $invoice->invoice_date ?? '',
                'paymentAmountDollar' => $invoice->first_pay_dollar ?? 0,
                'paymentAmountIraqi' => $invoice->first_pay_iraqi ?? 0,
            ];
        } else {
            $this->arr_payments[] = [
                'payment_date' =>  now()->format('Y-m-d'),
                'paymentAmountDollar' => 0,
                'paymentAmountIraqi' => 0,
            ];
        }
    
        // If user has index 0, keep it; otherwise, keep only index 0 empty
        if ($this->arr_payments[0] && empty($this->arr_payments[1])) {
            $this->arr_payments = [$this->arr_payments[0]];
        }
    }
    

    public function newRecPayment() {
        $this->arr_payments[] = [
            'payment_date' => '',
            'paymentAmountDollar' => 0,
            'paymentAmountIraqi' => 0,
        ];
    } // END FUNCTION OF ADD NEW SERVICE

    public function removePayment($index) {
        unset($this->arr_payments[$index]);
        $this->arr_payments = array_values($this->arr_payments); // Reset array keys
    } // END FUNCTION OF ADD DELETE SERVICE

    public function updatedFisrtPay() {
        $this->calculateTotals();
    }

    public function calculateTotals() {
        $totalDollar = 0;
  
        foreach ($this->arr_payments as $service) {
            $totalDollar += $service['serviceTotalDollar'];
        }

        $this->totalDollar = $totalDollar;
        $this->grandTotalDollar = $totalDollar - $this->discountDollar + $this->taxDollar;
        $this->dueDollar = $this->grandTotalDollar - $this->fisrtPayDollar; 

        $this->totalIraqi = $totalDollar * $this->exchange_rate;
        $this->discountIraqi = $this->discountDollar * $this->exchange_rate;
        $this->taxIraqi = $this->taxDollar * $this->exchange_rate;
        $this->fisrtPayIraqi = $this->fisrtPayDollar * $this->exchange_rate;
        
        $this->grandTotalIraqi = $this->taxIraqi + ($this->totalIraqi - $this->discountIraqi);
        $this->dueIraqi = $this->grandTotalIraqi - $this->fisrtPayIraqi;
    }

    public function exchangeUpdate(){
        foreach ($this->arr_payments as $index => $service) {
            $selectedService = Service::find($service['select_service_data']);
            if ($selectedService) {
                $this->arr_payments[$index]['serviceDefaultCostIraqi'] = $selectedService->price_dollar * $this->exchange_rate;
            }
            $this->serviceQtyChange($index);
        }
        $this->calculateTotals();
    }


public function selectDataInvoice(){
    if($this->selectNotAttached){
        $cashData = Invoice::where('id', $this->selectNotAttached)->first();

        $this->clientId = $cashData->client->id;
        $this->clientName = $cashData->client->client_name;
        $this->clientEmail = $cashData->client->email;
        $this->clientCountry = $cashData->client->country;
        $this->clientCity = $cashData->client->city;
        $this->clientAddress = $cashData->client->address;
        $this->clientPhoneOne = $cashData->client->phone_one;
        $this->clientPhoneTwo = $cashData->client->phone_two;

        $this->exchange_rate = $cashData->exchange_rate;
        
        // public $arr_payments = [];

        $this->formDateCash = now()->format('Y-m-d');
        $this->formDateInvoice = $cashData->invoice_date;

        $this->description = $cashData->description;
        $this->dueDollar = $cashData->due_dollar;
        $this->grandTotalDollar = $cashData->grand_total_dollar;
        $this->dueIraqi = $cashData->due_iraqi;
        $this->grandTotalIraqi = $cashData->grand_total_iraqi;

        
        $this->note = json_decode($cashData->notes, true);

        $this->initializeServicesArray($cashData ?? null);
    }
}


    protected function rules() {
        $rules = [];
        $rules['formDate'] = ['required'];
        $rules['status'] = ['required'];
        $rules['select_client_data'] = ['required'];
        $rules['select_payment_data'] = ['required'];
        $rules['arr_payments'] = ['required'];
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


    public function addInvoice(){
        try {
            $validatedData = $this->validate();

            $quotation = Invoice::create([
                'quotation_id' => null,
                'client_id' => $validatedData['select_client_data'],
                'payment_id' => $validatedData['select_payment_data'],
                'invoice_date' => $validatedData['formDate'],
                'exchange_rate' => $this->exchange_rate,
                'status' => $validatedData['status'],
                'services' => json_encode($validatedData['arr_payments']),
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
                    ->notify(new TelegramInvoiceNew(
                        $quotation->id,
                        $validatedData['formDate'],
                        null,
                        $validatedData['select_client_data'],
                        $validatedData['select_payment_data'],
                        $this->description ?? null,
                        $this->exchange_rate,
                        $validatedData['arr_payments'],
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

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Invoice Added Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    }

    public function editInvoice(int $invoiceId){
        try {
            $invoiceEdit = Invoice::find($invoiceId);
            $this->invoiceUpdate = $invoiceId;

            $clientInfo = Client::find($invoiceEdit->client_id);
            $paymentInfo = Payment::find($invoiceEdit->payment_id);
            $this->old_invoice_data = [];

            if ($invoiceEdit) {
                $this->old_invoice_data = null;
                // invoice Date
                $this->formDate = $invoiceEdit->invoice_date;
                // $this->quotationId = $invoiceEdit->qoutation_id;
                $this->status = $invoiceEdit->status;
                // Client Information
                $this->select_client_data =  $invoiceEdit->client_id;
                $this->clientName = $clientInfo->client_name;
                $this->clientEmail = $clientInfo->country;
                $this->clientCountry = $clientInfo->city;
                $this->clientCity = $clientInfo->address;
                $this->clientAddress = $clientInfo->email;
                $this->clientPhoneOne = $clientInfo->phone_one;
                $this->clientPhoneTwo = $clientInfo->phone_two;
                // Payment Method
                $this->select_payment_data = $invoiceEdit->payment_id;
                $this->exchange_rate = $invoiceEdit->exchange_rate;
                // Service Section
                $this->description = $invoiceEdit->description;
                $this->arr_payments = json_decode($invoiceEdit->services);
                // final Section
                $this->note = json_decode($invoiceEdit->notes, true) ?? [];
                $this->totalDollar = $invoiceEdit->total_amount_dollar;
                $this->taxDollar = $invoiceEdit->tax_dollar;
                $this->discountDollar = $invoiceEdit->discount_dollar;
                $this->fisrtPayDollar = $invoiceEdit->first_pay_dollar;
                $this->dueDollar = $invoiceEdit->due_dollar;
                $this->grandTotalDollar = $invoiceEdit->grand_total_dollar;
                $this->totalIraqi = $invoiceEdit->total_amount_iraqi;
                $this->taxIraqi = $invoiceEdit->tax_iraqi;
                $this->discountIraqi = $invoiceEdit->discount_iraqi;
                $this->fisrtPayIraqi = $invoiceEdit->first_pay_iraqi;
                $this->dueIraqi = $invoiceEdit->due_iraqi;
                $this->grandTotalIraqi = $invoiceEdit->grand_total_iraqi;

                $this->old_invoice_data = [
                    // invoice Date
                    'formDate' => $invoiceEdit->qoutation_date,
                    'status' => $invoiceEdit->status,
                    'quotationId' => $invoiceEdit->qoutation_id,
                    // Client Information
                    'select_client_data' =>  $invoiceEdit->client_id,
                    'clientName' => $clientInfo->client_name,
                    'clientEmail' => $clientInfo->country,
                    'clientCountry' => $clientInfo->city,
                    'clientCity' => $clientInfo->address,
                    'clientAddress' => $clientInfo->email,
                    'clientPhoneOne' => $clientInfo->phone_one,
                    'clientPhoneTwo' => $clientInfo->phone_two,
                    // Payment Method
                    'select_payment_data' => $invoiceEdit->payment_id,
                    'payment_type' => $paymentInfo->payment_type,
                    'exchange_rate' => $invoiceEdit->exchange_rate,
                    // Service Section
                    'description' => $invoiceEdit->description,
                    'arr_payments' => json_encode($invoiceEdit->services),
                    // final Section
                    'note' => json_decode($invoiceEdit->notes, true) ?? [],
                    'totalDollar' => $invoiceEdit->total_amount_dollar,
                    'taxDollar' => $invoiceEdit->tax_dollar,
                    'discountDollar' => $invoiceEdit->discount_dollar,
                    'fisrtPayDollar' => $invoiceEdit->first_pay_dollar,
                    'dueDollar' => $invoiceEdit->due_dollar,
                    'grandTotalDollar' => $invoiceEdit->grand_total_dollar,
                    'totalIraqi' => $invoiceEdit->total_amount_iraqi,
                    'taxIraqi' => $invoiceEdit->tax_iraqi,
                    'discountIraqi' => $invoiceEdit->discount_iraqi,
                    'fisrtPayIraqi' => $invoiceEdit->first_pay_iraqi,
                    'dueIraqi' => $invoiceEdit->due_iraqi,
                    'grandTotalIraqi' => $invoiceEdit->grand_total_iraqi,
                ];
            } else {
                return redirect()->to('own/invoice');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT INVOICE

    public function updateInvoice(){
        try {
            $validatedData = $this->validate();

            Invoice::where('id', $this->invoiceUpdate)->update([
                'client_id' => $validatedData['select_client_data'],
                'payment_id' => $validatedData['select_payment_data'],
                'exchange_rate' => $this->exchange_rate,
                'invoice_date' => $validatedData['formDate'],
                'status' => $validatedData['status'],
                'services' => json_encode($validatedData['arr_payments']),
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
                    ->notify(new TelegramInvoiceUpdate(
                        $this->invoiceUpdate,
                        $validatedData['formDate'],
                        $this->quotationId,
                        $clientName,
                        $paymentType,
                        $this->description ?? null,
                        $this->exchange_rate,
                        $validatedData['arr_payments'],
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

                        $this->old_invoice_data,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Invoice Updated Successfully')]);
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
    } // END FUNCTION OF UPDATE INVOICE

    public function deleteInvoice(int $selected_invoice_id){
        $this->del_invoice_id = $selected_invoice_id;
        $this->del_invoice_data = Invoice::find($this->del_invoice_id);
        if($this->del_invoice_data){
            // $this->del_invoice_name = $this->del_invoice_data->invoice_name;
            $this->del_invoice_name = 'delete';
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END FUNCTION OF DELETE INVOICE

    public function destroyInvoice(){
        if ($this->confirmDelete && $this->invoice_name_to_selete === $this->del_invoice_name) {

            Invoice::find($this->del_invoice_id)->delete();
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramInvoiceDelete(
                        $this->del_invoice_id,
                        $this->tele_id,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            
            $quotationTemp = Quotation::find($this->del_invoice_data->quotation_id);

            if ($quotationTemp) {
                $updated = $quotationTemp->update([
                    'quotation_status' => 'Rejected',
                ]);

                if ($updated) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('The Attached Quotation Has Been Rejected')]);
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('The Attached Quotation Has not Been Rejected')]);
                }
            } else {
                // Handle the case where the Quotation record with the specified ID is not found
            }
            $this->del_invoice_id = null;
            $this->del_invoice_data = null;
            $this->del_invoice_name = null;
            $this->invoice_name_to_selete = null;
            $this->confirmDelete = false;
            $this->resetModal();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Client Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->del_invoice_name]);
        }
    } // END FUNCTION OF DESTROY CLIENT

    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->formDate = '';
        $this->status = '';

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
        $this->arr_payments = [];
        $this->description = '';
        $this->note = [];
        $this->totalDollar = null;
        $this->taxDollar = null;
        $this->discountDollar = null;
        $this->fisrtPayDollar = null;
        $this->dueDollar = null;
        $this->grandTotalDollar = null;
        $this->totalIraqi = null;
        $this->taxIraqi = null;
        $this->discountIraqi = null;
        $this->fisrtPayIraqi = null;
        $this->dueIraqi = null;
        $this->grandTotalIraqi = null;

        $this->client_data = Client::get();
        $this->payment_data = Payment::get();
        $this->service_data = Service::get();

        $this->initializeServicesArray(null);
    } // END FUNCTION OF RESET VARIABLES

    public function closeModal() {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    public function updateStatus(int $invoice_Id) {
        $itemState = Invoice::find($invoice_Id);
        // Toggle the status (0 to 1 and 1 to 0)
        $this->old_invoice_data = [
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
                ->notify(new TelegramInvoiceShort(
                    $invoice_Id,
                    $clientName,
                    $itemState->status,

                    $this->old_invoice_data,
                    $this->tele_id,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $itemState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Invoice Status Updated Successfully')]);
    } // END FUNCTION OF UPDATING PRIOEITY

    public function resetFilter(){
        $this->search = null;
        $this->statusFilter = '';
        $this->quotationId= null;
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
        $cols_th = ['#','Client Name', 'Quotation ID','Payment Type', 'Description', 'Total', 'Grand Total', 'Status','Date','Created Date', 'Actions'];
        $cols_td = ['id','client.client_name','quotation_id','payment.payment_type','description','grand_total_dollar','grand_total_iraqi','status','invoice_date','created_at'];

        $data = Invoice::with(['client', 'payment'])
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
            $query->whereBetween('invoice_date', [$this->startDate, $this->endDate]);
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
        ->orderBy('invoice_date', 'DESC')
        ->paginate(15);
        
        return view('livewire.own.cash-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}
