<?php

namespace App\Http\Livewire\Fin;

use App\Models\Cash;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Fin\TelegramCashNew;
use App\Notifications\Fin\TelegramClientNew;
use App\Notifications\Fin\TelegramInvoiceNew;
use App\Notifications\Fin\TelegramInvoiceShort;
use App\Notifications\Fin\TelegramInvoiceUpdate;

class InvoiceLivewire extends Component
{



    use WithPagination; 
    // use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    // Form Date Section
    public $quotationId;
    public $formDate;
    public $status;
    public $print_id_selected;
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
    public $arr_service_by_date = [];
    // Form Final Section
    public $description;
    public $note = [];
    public $totalDollar = 0;
    public $taxDollar = 0;
    public $discountDollar = 0;
    public $fisrtPayDollar = 0;
    public $dueDollar = 0;
    public $grandTotalDollar = 0;
    public $totalIraqi = 0;
    public $taxIraqi = 0;
    public $discountIraqi = 0;
    public $fisrtPayIraqi = 0;
    public $dueIraqi = 0;
    public $grandTotalIraqi = 0;
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
    // Direct Forms Variables
    public $dClientName;
    public $country;
    public $city;
    public $address;
    public $email;
    public $phoneOne;
    public $phoneTwo;

    protected $listeners = [ 'dateRangeSelected' => 'applyDateRangeFilter' ];

    public function mount() {
        $this->formDate = now()->format('Y-m-d');
        $this->telegram_channel_status = 1;
        $this->tele_id = env('TELEGRAM_GROUP_ID');
        $this->client_data = Client::get();
        $this->payment_data = Payment::get();
        $this->service_data = Service::get();
        $this->initializeServicesArray();
    } // END FUNCTION OF PAGE LOAD

    // Show before Print
    public function printCustomPdf(int $invoiceId){
        try {
            $invoiceEditasd = Invoice::where('id',$invoiceId)->first();

            $imagePath = public_path('assets/dashboard/img/mainlogopdf.png');
            $imageData = base64_encode(File::get($imagePath));
            $base64Image = 'data:image/jpeg;base64,' . $imageData;
            
            $data = [
                "img" => $base64Image,

                "invoiceId" => $invoiceEditasd->id,
                "client" => $invoiceEditasd->client->client_name ?? 'UnKnown',
                "email" => $invoiceEditasd->client->email ?? 'UnKnown',
                "country" => $invoiceEditasd->client->country ?? 'UnKnown',
                "city" => $invoiceEditasd->client->city ?? 'UnKnown',
                "phoneOne" => $invoiceEditasd->client->phone_one ?? 'UnKnown',
                "phoneTwo" => $invoiceEditasd->client->phone_two ?? 'UnKnown',
                
                "date" =>$invoiceEditasd->invoice_date ?? 'UnKnown',
                "total" => $invoiceEditasd->grand_total_dollar ?? 'UnKnown',
                "clientId" => $invoiceEditasd->client->id ?? 'UnKnown',

                "serviceData" => json_decode($invoiceEditasd->services,true) ?? 'XXX',

                "amountDollar" => $invoiceEditasd->total_amount_dollar ?? '$XXXX',
                "discount" => $invoiceEditasd->discount_dollar ?? '$XXXX',
                "grandDollar" => $invoiceEditasd->grand_total_dollar ?? '$XXXX',

                "notes" => $invoiceEditasd->notes ?? '$XXXX',
            ];

            $pdfContent = PDF::loadView('dashboard.pdf.pdfInvoice', $data)->output();
            return response()->streamDownload(
                function () use ($pdfContent) {
                    echo $pdfContent;
                },
                $invoiceEditasd->id.'_'.$invoiceEditasd->client->client_name.'_'.now()->format('Y-m-d').'.pdf'
            );
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Something Went Wrong.')]);
        }
        
    } 
   

    // Direct Print
    public function printDirectPdf(int $invoiceId){
        $invoiceEditasd = Invoice::where('id',$invoiceId)->first();

        $imagePath = public_path('assets/dashboard/img/mainlogopdf.png');
            $imageData = base64_encode(File::get($imagePath));
            $base64Image = 'data:image/jpeg;base64,' . $imageData;
            // public/assets/dashboard/img/mainlogopdf.png
        $data = [
            "img" => $base64Image,

            "invoiceId" => $invoiceEditasd->id,
            "client" => $invoiceEditasd->client->client_name ?? 'UnKnown',
            "email" => $invoiceEditasd->client->email ?? 'UnKnown',
            "country" => $invoiceEditasd->client->country ?? 'UnKnown',
            "city" => $invoiceEditasd->client->city ?? 'UnKnown',
            "phoneOne" => $invoiceEditasd->client->phone_one ?? 'UnKnown',
            "phoneTwo" => $invoiceEditasd->client->phone_two ?? 'UnKnown',
            
            "date" =>$invoiceEditasd->invoice_date ?? 'UnKnown',
            "total" => $invoiceEditasd->grand_total_dollar ?? 'UnKnown',
            "clientId" => $invoiceEditasd->client->id ?? 'UnKnown',

            "serviceData" => json_decode($invoiceEditasd->services,true) ?? 'XXX',

            "amountDollar" => $invoiceEditasd->total_amount_dollar ?? '$XXXX',
            "discount" => $invoiceEditasd->discount_dollar ?? '$XXXX',
            "grandDollar" => $invoiceEditasd->grand_total_dollar ?? '$XXXX',

            "notes" => $invoiceEditasd->notes ?? '$XXXX',
        ];

        $pdfContent = PDF::loadView('dashboard.pdf.pdfInvoice', $data)->output();


        $this->dispatchBrowserEvent('printPdf', [
            'pdfContent' => base64_encode($pdfContent),
            'filename' => $invoiceEditasd->id . '_' . $invoiceEditasd->client->client_name . '_' . now()->format('Y-m-d') . '.pdf',
        ]);
    } 

 
    public function createEmptyService() {
        return [
            'serviceCode' => '',
            'select_service_data' => null,
            'serviceDescription' => '',
            'serviceDefaultCostDollar' => 0,
            'serviceDefaultCostIraqi' => 0,
            'serviceQty' => 1,
            'serviceTotalDollar' => 0,
            'serviceTotalIraqi' => 0,
        ];
    }

    public function initializeServicesArray() {
        // $date = now()->format('Y-m-d');
        $this->arr_service_by_date[0] = [
            'actionDate' => '',
            'description' => '',
        ];

        for ($i = 0; $i < 3; $i++) {
            $this->arr_service_by_date[0]['services'][] = $this->createEmptyService();
        }
    }

    public function newRecService($dateIndex) {
        $this->arr_service_by_date[$dateIndex]['services'][] = $this->createEmptyService();
    }

    public function removeService($dateIndex, $serviceIndex) {
        unset($this->arr_service_by_date[$dateIndex]['services'][$serviceIndex]);
        $this->arr_service_by_date[$dateIndex]['services'] = array_values($this->arr_service_by_date[$dateIndex]['services']);
    }

    public $newDate;
    public function addNewDate()
    {
        // $newDate = now()->format('Y-m-d');
        $newDateData = [
            'actionDate' => '',
            'description' => '',
            'services' => [ $this->createEmptyService() ],
        ];
    
        // Reset the newDate property
        $this->arr_service_by_date[] = $newDateData;
        $this->newDate = null;
        // This line will notify Livewire about the updated data
        $this->arr_service_by_date = collect($this->arr_service_by_date)->values()->all();

        // $this->arr_service_by_date = array_values($this->arr_service_by_date);
    }
    

    public function removeDate($dateIndex)
    {
        unset($this->arr_service_by_date[$dateIndex]);
        // Re-index the array to avoid any missing indices
        $this->arr_service_by_date = array_values($this->arr_service_by_date);
    }

    public $showTextarea = 1;
    public function serviceQtyChange($date, $index) {
        $this->arr_service_by_date[$date]['services'][$index]['serviceTotalDollar'] = $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostDollar'] * $this->arr_service_by_date[$date]['services'][$index]['serviceQty'];
        $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostIraqi'] = $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostDollar'] * $this->exchange_rate;
        $this->arr_service_by_date[$date]['services'][$index]['serviceTotalIraqi'] = $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostIraqi'] * $this->arr_service_by_date[$date]['services'][$index]['serviceQty'];
        $this->calculateTotals();
    }

    public function selectServiceDataChange($date, $index) {
        $selectedService = Service::find($this->arr_service_by_date[$date]['services'][$index]['select_service_data']);
        if ($selectedService) {
            $this->arr_service_by_date[$date]['services'][$index]['serviceCode'] = $selectedService->service_code;
            $this->arr_service_by_date[$date]['services'][$index]['serviceDescription'] = $selectedService->service_description;
            $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostDollar'] = $selectedService->price_dollar;
            $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostIraqi'] = $selectedService->price_dollar * $this->exchange_rate;
            $this->arr_service_by_date[$date]['services'][$index]['serviceTotalDollar'] = $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostDollar'] * $this->arr_service_by_date[$date]['services'][$index]['serviceQty'];
            $this->arr_service_by_date[$date]['services'][$index]['serviceTotalIraqi'] = $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostIraqi'] * $this->arr_service_by_date[$date]['services'][$index]['serviceQty'];

            $this->calculateTotals();
        }
    }

    public function exchangeUpdate() {
        foreach ($this->arr_service_by_date as $date => $services) {
            foreach ($services['services'] as $index => $service) {
                $selectedService = Service::find($service['select_service_data']);
                if ($selectedService) {
                    $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostIraqi'] = $selectedService->price_dollar * $this->exchange_rate;
                    $this->arr_service_by_date[$date]['services'][$index]['serviceTotalIraqi'] = $this->arr_service_by_date[$date]['services'][$index]['serviceDefaultCostIraqi'] * $this->arr_service_by_date[$date]['services'][$index]['serviceQty'];
                }
            }
        }
        $this->calculateTotals();
    }

    public function updatedDiscount() {
        $this->calculateTotals();
    }

    public function updatedFisrtPay() {
        $this->calculateTotals();
    }


    public function calculateTotals() {
        $totalDollar = 0;
    
        foreach ($this->arr_service_by_date as $services) {
            foreach ($services['services'] as $service) {
                $totalDollar += $service['serviceTotalDollar'] ?? 0;
            }
        }
    
        $this->totalDollar = $totalDollar;
        $this->totalIraqi = $totalDollar * $this->exchange_rate;
    
        $this->discountIraqi = $this->discountDollar * $this->exchange_rate;
        $this->taxIraqi = $this->taxDollar * $this->exchange_rate;
        $this->fisrtPayIraqi = $this->fisrtPayDollar * $this->exchange_rate;
    
        $grandTotalDollar = $totalDollar - $this->discountDollar + $this->taxDollar;
        $this->grandTotalDollar = max(0, $grandTotalDollar);
        $this->dueDollar = max(0, $this->grandTotalDollar - $this->fisrtPayDollar);
    
        $grandTotalIraqi = $this->taxIraqi + ($this->totalIraqi - $this->discountIraqi);
        $this->grandTotalIraqi = max(0, $grandTotalIraqi);
        $this->dueIraqi = max(0, $this->grandTotalIraqi - $this->fisrtPayIraqi);
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
        $rules['select_client_data'] = ['required'];
        $rules['select_payment_data'] = ['required'];
        $rules['arr_service_by_date'] = ['required'];
        $rules['totalDollar'] = ['required'];
        // $rules['taxDollar'] = ['required'];
        $rules['discountDollar'] = ['required'];
        $rules['fisrtPayDollar'] = ['required'];
        $rules['dueDollar'] = ['required'];
        $rules['grandTotalDollar'] = ['required'];
        $rules['totalIraqi'] = ['required'];
        // $rules['taxIraqi'] = ['required'];
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
                        auth()->user()->name,
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
    
    public function addInvoice(){

        try {
            $validatedData = $this->validate();
            $invoice = Invoice::create([
                'quotation_id' => null,
                'client_id' => $validatedData['select_client_data'],
                'payment_id' => $validatedData['select_payment_data'],
                'invoice_date' => now()->format('Y-m-d'),
                'exchange_rate' => $this->exchange_rate,
                'status' => $validatedData['status'],
                'services' => json_encode($validatedData['arr_service_by_date']),
                'total_amount_dollar' => $validatedData['totalDollar'],
                'tax_dollar' => 0,
                'discount_dollar' => $validatedData['discountDollar'],
                'first_pay_dollar' => $validatedData['fisrtPayDollar'],
                'due_dollar' => $validatedData['dueDollar'],
                'grand_total_dollar' => $validatedData['grandTotalDollar'],
                'total_amount_iraqi' => $validatedData['totalIraqi'],
                'tax_iraqi' => 0,
                'discount_iraqi' => $validatedData['discountIraqi'],
                'first_pay_iraqi' => $validatedData['fisrtPayIraqi'],
                'due_iraqi' => $validatedData['dueIraqi'],
                'grand_total_iraqi' => $validatedData['grandTotalIraqi'],
                'description' => $this->description,
                'notes' => $this->note,
            ]);

            $fisrt_payment_arr = [];
            if($validatedData['dueDollar'] == 0 ){
                $cash_status = 'Complete';
            } else {
                $cash_status = 'Not Complete';
            }

            $fisrt_payment_arr = json_encode([[
                'payment_date' => now()->format('Y-m-d') ?? '',
                'paymentAmountDollar' => $validatedData['fisrtPayDollar'],
                'paymentAmountIraqi' => $validatedData['fisrtPayIraqi'],
            ]], false);
            
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramInvoiceNew(
                        auth()->user()->name,
                        $invoice->id,
                        $validatedData['formDate'],
                        null,
                        $validatedData['select_client_data'],
                        $validatedData['select_payment_data'],
                        $this->description ?? null,
                        $this->exchange_rate,
                        $validatedData['arr_service_by_date'],
                        0,
                        $validatedData['discountDollar'],
                        $validatedData['fisrtPayDollar'],
                        $validatedData['dueDollar'],
                        0,
                        $validatedData['discountIraqi'],
                        $validatedData['fisrtPayIraqi'],
                        $validatedData['dueIraqi'],
                        $validatedData['totalDollar'],
                        $validatedData['totalIraqi'],
                        $validatedData['grandTotalDollar'],
                        $validatedData['grandTotalIraqi'],

                        $this->tele_id
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending INV Notification.')]);
                }
            }

            if(isset($validatedData['fisrtPayDollar']) && $validatedData['fisrtPayDollar'] > 0){
                $cash = Cash::create([
                    'invoice_id' => $invoice->id,
                    'cash_date' => now()->format('Y-m-d'),
                    // 'payments' => json_encode($validatedData['arr_payments']),
                    'payments' => $fisrt_payment_arr,
    
                    'grand_total_dollar' => $validatedData['grandTotalDollar'],
                    'due_dollar' => $validatedData['dueDollar'],
    
                    'grand_total_iraqi' => $validatedData['grandTotalIraqi'],
                    'due_iraqi' => $validatedData['dueIraqi'],
    
                    'cash_status' => $cash_status,
                ]);

                if($this->telegram_channel_status == 1){
                    try{
                        Notification::route('toTelegram', null)
                        ->notify(new TelegramCashNew(
                            auth()->user()->name,
                            $cash->id,
                            now()->format('Y-m-d'),
                            $invoice->id,
                            json_decode($fisrt_payment_arr, true),
                            $validatedData['dueDollar'],
                            $validatedData['dueIraqi'],
                            $validatedData['grandTotalDollar'],
                            $validatedData['grandTotalIraqi'],
    
                            $this->tele_id
                        ));
                        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                    }  catch (\Exception $e) {
                        $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Invoice Notification.')]);
                    }
                }


            }

                try{
                    $this->printDirectPdf($invoice->id);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while Printing Invoice.')]);
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
            $this->print_id_selected = $invoiceId;

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
                $this->arr_service_by_date = json_decode($invoiceEdit->services, true);
                // final Section
                $this->note = json_decode($invoiceEdit->notes, true);
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
                    'formDate' => $invoiceEdit->invoice_date,
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
                    'arr_service_by_date' => json_encode($invoiceEdit->services, true),
                    // final Section
                    'note' => $invoiceEdit->notes,
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
                return redirect()->to('fin/invoice');
            }
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Could Not Load The Data')]);
        }
    } // END FUNCTION OF EDIT INVOICE

    public function updateInvoice(){
        // try {
            $validatedData = $this->validate();

            Invoice::where('id', $this->invoiceUpdate)->update([
                'client_id' => $validatedData['select_client_data'],
                'payment_id' => $validatedData['select_payment_data'],
                'exchange_rate' => $this->exchange_rate,
                'invoice_date' => $validatedData['formDate'],
                'status' => $validatedData['status'],
                'services' => json_encode($validatedData['arr_service_by_date']),
                'total_amount_dollar' => $validatedData['totalDollar'],
                'tax_dollar' =>0,
                'discount_dollar' => $validatedData['discountDollar'],
                'first_pay_dollar' => $validatedData['fisrtPayDollar'],
                'due_dollar' => $validatedData['dueDollar'],
                'grand_total_dollar' => $validatedData['grandTotalDollar'],
                'total_amount_iraqi' => $validatedData['totalIraqi'],
                'tax_iraqi' => 0,
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
                        auth()->user()->name,
                        $this->invoiceUpdate,
                        $validatedData['formDate'],
                        $this->quotationId,
                        $clientName,
                        $paymentType,
                        $this->description ?? null,
                        $this->exchange_rate,
                        $validatedData['arr_service_by_date'],
                        0, // $validatedData['taxDollar'],
                        $validatedData['discountDollar'],
                        $validatedData['fisrtPayDollar'],
                        $validatedData['dueDollar'],
                        0, // $validatedData['taxIraqi'],
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
        // } catch (\Exception $e){
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        // }
    } // END FUNCTION OF UPDATE INVOICE

    public function deleteMessage(){
        $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => __('HA HA HA, Nice Try')]);
    } // END FUNCTION OF DELETE CLIENT


    // PRIVATE & PUBLIC FUNCTIONS
    private function resetModal(){
        $this->formDate = now()->format('Y-m-d');
        $this->status = '';
        $this->quotationId = null;
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
        $this->arr_service_by_date = [];
        $this->description = '';
        $this->note = null;
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
                    auth()->user()->name,
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
        $cols_th = ['#','Client Name', 'Quotation ID','Payment Type', 'Title', 'Total', 'Grand Total', 'Status','Created Date', 'Actions'];
        $cols_td = ['id','client.client_name','quotation_id','payment.payment_type','description','grand_total_dollar','grand_total_iraqi','status','created_at'];

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
        
        return view('livewire.fin.invoice-table',[
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}
