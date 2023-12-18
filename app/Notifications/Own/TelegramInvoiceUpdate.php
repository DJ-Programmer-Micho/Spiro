<?php

namespace App\Notifications\Own;

use App\Models\Service;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramInvoiceUpdate extends Notification
{
    protected $i_id;
    protected $date;
    protected $quotationId;
    protected $clientId;
    protected $paymentId;
    protected $desc;
    protected $service = [];
    protected $exchangeRate;

    protected $taxDollar;
    protected $discountDollar;
    protected $fisrtpayDollar;
    protected $dueDollar;

    protected $taxIraqi;
    protected $discountIraqi;
    protected $fisrtpayIraqi;
    protected $dueIraqi;

    protected $totalDollar;
    protected $totalIraqi;

    protected $notes;
    protected $status;
    protected $quotationStatus;

    protected $clientName;
    protected $paymentType;
    protected $tableHeader;
    protected $tableBody;


    protected $old_invoice_data;
    protected $tele_id;

    public function __construct($i_id, $date, $quotationId, $clientId, $paymentId, $desc, $exchangeRate, $service, $taxDollar, $discountDollar, $fisrtpayDollar, $dueDollar, $taxIraqi, $discountIraqi, $fisrtpayIraqi, $dueIraqi, $totalDollar, $totalIraqi, $notes, $status, $old_invoice_data, $tele_id)
    {
        $this->i_id = $i_id;
        $this->date = $date;
        $this->quotationId = $quotationId;
        $this->clientId = $clientId;
        $this->paymentId = $paymentId;
        $this->desc = $desc;
        $this->exchangeRate = $exchangeRate;
        $this->service = $service;
        

        $this->taxDollar = $taxDollar;
        $this->discountDollar = $discountDollar;
        $this->fisrtpayDollar = $fisrtpayDollar;
        $this->dueDollar = $dueDollar;
        $this->taxIraqi = $taxIraqi;
        $this->discountIraqi = $discountIraqi;
        $this->fisrtpayIraqi = $fisrtpayIraqi;
        $this->dueIraqi = $dueIraqi;
        $this->totalDollar = $totalDollar;
        $this->totalIraqi = $totalIraqi;

        $this->notes = $notes;
        $this->status = $status;

        $this->old_invoice_data = $old_invoice_data;
        $this->tele_id = $tele_id;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->old_invoice_data['status'] = $this->old_invoice_data['status'] == 0 ?  "DeActive" : "Active";
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#INV-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'INVOICE UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'INVOICE-ID: '. $registrationId . '-'. $this->i_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n";

        if ($this->clientId !== $this->old_invoice_data['clientName']) {
            $content .= "*" . 'Client Changed: '. $this->old_invoice_data['clientName'] . ' ➡️ ' . $this->clientId . "*\n";
        } else {
            $content .= "*" . 'Client Invocie: '. $this->old_invoice_data['clientName'] . "*\n"
            . "*" .'-----------------'."*\n";
        }

        if ($this->date !== $this->old_invoice_data['formDate']) {
            $content .= "*" . 'Quotatin Date Changed: '. $this->old_invoice_data['formDate'] . ' ➡️ ' . $this->date . "*\n";
        }
        
        if ($this->exchangeRate !== $this->old_invoice_data['exchange_rate']) {
            $content .= "*" . 'Exchange Rate Changed: $1 ~ '. $this->old_invoice_data['exchange_rate'] . 'IQD ➡️ $1 ~ ' . $this->exchangeRate . 'IQD' . "*\n";
        }
        

        if ($this->paymentId !== $this->old_invoice_data['payment_type']) {
            $content .= "*" . 'Payment Changed: '. $this->old_invoice_data['payment_type'] . ' ➡️ ' . $this->paymentId . "*\n";
        }

        if ($this->desc !== $this->old_invoice_data['description']) {
            $content .= "*" . 'Description Changed: '. $this->old_invoice_data['description'] . ' ➡️ ' . $this->desc . "*\n";
        }

        if ($this->status !== $this->old_invoice_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_invoice_data['status'] . ' ➡️ ' . $this->status . "*\n";
        }

        if ($this->quotationId !== $this->old_invoice_data['quotationId']) {
            $content .= "*" . 'Quotation ID Changed: '. $this->old_invoice_data['quotationId'] . ' ➡️ ' . $this->quotationId . "*\n";
        }

        if ($this->taxDollar !== $this->old_invoice_data['taxDollar']) {
            $content .=  "*" .'-----------------'."*\n"
            . 'TAX Changed ($): $'. $this->old_invoice_data['taxDollar'] . ' ➡️ $' . $this->taxDollar . "*\n";
        }
        if (strval($this->taxIraqi) !== $this->old_invoice_data['taxIraqi']) {
            $content .= "*" . 'TAX Changed (IQD): '. $this->old_invoice_data['taxIraqi'] . 'IQD ➡️ ' . $this->taxIraqi . 'IQD' . "*\n"
            . "*" .'-----------------'."*\n";
        }

        if ($this->discountDollar !== $this->old_invoice_data['discountDollar']) {
            $content .= "*" . 'Discount Changed: $'. $this->old_invoice_data['discountDollar'] . ' ➡️ $' . $this->discountDollar . "*\n";
        }
        if (strval($this->discountIraqi) !== $this->old_invoice_data['discountIraqi']) {
            $content .= "*" . 'Discount Changed (IQD): '. $this->old_invoice_data['discountIraqi'] . 'IQD ➡️ ' . $this->discountIraqi . 'IQD' . "*\n"
            . "*" .'-----------------'."*\n";
        }

        if ($this->fisrtpayDollar !== $this->old_invoice_data['fisrtPayDollar']) {
            $content .= "*" . 'First Pay Changed: $'. $this->old_invoice_data['fisrtPayDollar'] . ' ➡️ $' . $this->fisrtpayDollar . "*\n";
        }
        if (strval($this->fisrtpayIraqi) !== $this->old_invoice_data['fisrtPayIraqi']) {
            $content .= "*" . 'First Pay Changed: (IQD)'. $this->old_invoice_data['fisrtPayIraqi'] . 'IQD ➡️ ' . $this->fisrtpayIraqi . 'IQD' . "*\n"
            . "*" .'-----------------'."*\n";
        }

        if ($this->dueDollar !== $this->old_invoice_data['dueDollar']) {
            $content .= "*" . 'Due Changed: $'. $this->old_invoice_data['dueDollar'] . ' ➡️ $' . $this->dueDollar . "*\n";
        }
        if ($this->dueIraqi !== $this->old_invoice_data['dueIraqi']) {
            $content .= "*" . 'Due Changed: '. $this->old_invoice_data['dueIraqi'] . 'IQD ➡️ ' . $this->dueIraqi . 'IQD' . "*\n"
            . "*" .'-----------------'."*\n";
        }

        if ($this->totalDollar !== $this->old_invoice_data['grandTotalDollar']) {
            $content .= "*" . 'Grand Total Changed: $'. $this->old_invoice_data['grandTotalDollar'] . ' ➡️ $' . $this->totalDollar  . "*\n";
        }
        if ($this->totalIraqi !== $this->old_invoice_data['grandTotalIraqi']) {
            $content .= "*" . 'Grand Total Changed: '. $this->old_invoice_data['grandTotalIraqi'] . 'IQD ➡️ ' . $this->totalIraqi . 'IQD' . "*\n"
            . "*" .'-----------------'."*\n";
        }

        function compareServices($oldService, $newService) {
            $changes = [];
        
            foreach ($oldService as $key => $oldValue) {
                if ($oldValue !== $newService[$key]) {
                    $changes[$key] = [
                        'old' => $oldValue,
                        'new' => $newService[$key],
                    ];
                }
            }
        
            return $changes;
        }
        
        $oldServices = json_decode(json_decode($this->old_invoice_data['arr_service'], true));
        $newServices = $this->service;
        
        $content .= "*" . 'Services Changes:' . "*\n";
        // $content .= "*" . '-----------------' . "*\n";
        
        $maxCount = max(count($oldServices), count($newServices));
        
        for ($index = 0; $index < $maxCount; $index++) {
            $oldService = $oldServices[$index] ?? null;
            $newService = $newServices[$index] ?? null;
        
            if ($oldService && $newService) {
                // Both arrays have an element at this index, compare them
                $serviceChanges = compareServices($oldService, $newService);
        
                // If there are changes, display them
                if (!empty($serviceChanges)) {

                    // $old_serviceName_2 = Service::find($serviceChanges['select_service_data']['old'])->service_name ?? 'Unknown Service';
                    $old_serviceName_2 = Service::find($oldService->select_service_data)->service_name ?? 'Unknown Service';
                    $new_serviceName_2 = Service::find($newService['select_service_data'])->service_name ?? 'Unknown Service';
                    $content .= "*" . '-----------------' . "*\n";
                    $content .= "*" . 'Service at Position ' . ($index + 1) . "*\n";
        
                    // Display specific changes
                    foreach ($serviceChanges as $key => $change) {
                        if ($key === 'select_service_data') {
                            $content .= "*" . 'Name: ' . ": " . $old_serviceName_2 . ' ➡️ ' .$new_serviceName_2  . "*\n";
                        } else {
                            $content .= "*" . ucfirst($key) . ": " . $change['old'] . ' ➡️ ' . $change['new'] . "*\n";
                        }
                    }
                }
            } elseif ($oldService) {
                // Only old array has an element at this index
                $old_serviceName = Service::find($oldService->select_service_data)->service_name ?? 'Unknown Service';
                $content .= "*" . 'Service at Position ' . ($index + 1) . ' ('. $old_serviceName . ') was removed.' . "*\n";
            } elseif ($newService) {
                // Only new array has an element at this index
                $new_serviceName = Service::find($newService['select_service_data'])->service_name ?? 'Unknown Service';
                $content .= "*" . '-----------------' . "*\n"
                    . "*" . 'Service at Position ' . ($index + 1) . ' was added.' . "*\n"
                    . "*" . 'Code: '.  $newService['serviceCode'] . "*\n"
                    . "*" . 'Name: '.  $new_serviceName . "*\n"
                    . "*" . 'Description: '.  $newService['serviceDescription'] . "*\n"
                    . "*" . 'Cost ($): '.  $newService['serviceDefaultCostDollar'] . "*\n"
                    . "*" . 'Cost (IQD): '.  $newService['serviceDefaultCostIraqi'] . "*\n"
                    . "*" . 'QTY: '.  $newService['serviceQty'] . "*\n"
                    . "*" . 'Total ($): '.  $newService['serviceTotalDollar'] . "*\n"
                    . "*" . 'Total (IQD): '.  $newService['serviceTotalIraqi'] . "*\n";
            }
        }
        
       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content($content);
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
