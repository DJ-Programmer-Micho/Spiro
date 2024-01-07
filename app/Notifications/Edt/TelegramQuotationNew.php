<?php

namespace App\Notifications\Edt;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramQuotationNew extends Notification
{
    protected $addBy;
    protected $q_id;
    protected $date;
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

    protected $clientName;
    protected $paymentType;
    protected $tableHeader;
    protected $tableBody;

    protected $note;

    protected $tele_id;

    public function __construct($addBy, $q_id, $date, $clientId, $paymentId, $desc, $exchangeRate, $service, $taxDollar, $discountDollar, $fisrtpayDollar, $dueDollar, $taxIraqi, $discountIraqi, $fisrtpayIraqi, $dueIraqi, $totalDollar, $totalIraqi, $note, $tele_id)
    {
        $this->addBy = $addBy;
        $this->q_id = $q_id;
        $this->date = $date;
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

        $this->note = $note;

        $this->tele_id = $tele_id;

        // dd($this->service);
        // Handling for $clientId
        if ($clientId) {
            $client = Client::find($clientId);

            if ($client) {
                $this->clientName = $client->client_name;
            } else {
                $this->clientName = 'Unknown Client';
            }
        } else {
            $this->clientName = 'Invalid Client ID';
        }

        // Handling for $paymentId
        if ($paymentId) {
            $payment = Payment::find($paymentId);

            if ($payment) {
                $this->paymentType = $payment->payment_type;
            } else {
                $this->paymentType = 'Unknown Payment Type';
            }
        } else {
            $this->paymentType = 'Invalid Payment ID';
        }

        $this->tableHeader = "*# | Service Name | Cost ($) | Cost (IQD) | QTY | Total ($) | Total (IQD)*\n";
        $this->tableBody = collect($this->service)->map(function ($action, $actionIndex) {
            $date = $this->service[$actionIndex]['actionDate'];
            $description = $this->service[$actionIndex]['description'];
        
            $serviceTable = collect($action['services'])->map(function ($service, $serviceIndex) {
                $serviceName = Service::find($service['select_service_data'])->service_name ?? 'Unknown Service';
                return sprintf(
                    "*%s | %s | $ %s | %s IQD | %s | $ %s | %s IQD*",
                    $serviceIndex + 1,
                    $serviceName,
                    number_format($service['serviceDefaultCostDollar']),
                    number_format($service['serviceDefaultCostIraqi']),
                    $service['serviceQty'],
                    number_format($service['serviceTotalDollar']),
                    number_format($service['serviceTotalIraqi'])
                );
            })->implode("\n");
            // return "*Date: $date *\nDescription: $description*\n$serviceTable\n-----------------";
            return "*---\nDate: $date \nDescription: $description\n---*\n$serviceTable\n";

            // return "*Date: $date | Description: $description*\n$serviceTable";
        })->implode("\n");
        

    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#QUO-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'QUOTATION ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'Added By: '. $this->addBy . "*\n"
       . "*" .'QUOTATION-ID: #QUO-'. $this->q_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Date: '. $this->date . "*\n"
       . "*" .'Client: '. $this->clientName . "*\n"
       . "*" .'Payment: '. $this->paymentType . "*\n"
       . "*" .'Title: '. $this->desc . "*\n"
       . "*" .'Exchange Rate: $1 ~ '. $this->exchangeRate . " IQD *\n"
    //    . "*" .'--'."*\n"
    //    . "*" .'TAX ($): $ '. number_format($this->taxDollar). "*\n"
    //    . "*" .'TAX (IQD): '. number_format($this->taxIraqi) . ' IQD' . "*\n"
       . "*" .'--'."*\n"
       . "*" .'Discount ($): $'. number_format($this->discountDollar). "*\n"
       . "*" .'Discount (IQD): '. number_format($this->discountIraqi) . ' IQD' . "*\n"
    //    . "*" .'--'."*\n"
    //    . "*" .'First Pay ($): $'. number_format($this->fisrtpayDollar). "*\n"
    //    . "*" .'First Pay (IQD): '. number_format($this->fisrtpayIraqi) . ' IQD' . "*\n"
    //    . "*" .'--'."*\n"
    //    . "*" .'Due ($): $'. number_format($this->fisrtpayDollar). "*\n"
    //    . "*" .'Due (IQD): '. number_format($this->fisrtpayIraqi) . ' IQD' . "*\n"
       . "*" .'--'."*\n"
       . "*" .'Total Cost ($): $'. number_format($this->totalDollar). "*\n"
       . "*" .'Total Cost (IQD): '. number_format($this->totalIraqi) . ' IQD' . "*\n"
       . "*" .'------- Note -------'."*\n"
       . "*" .'Notes: ' . "*\n"
       . "*" . $this->note . "*\n"
       . "*" .'------- Table -------'."*\n"
       . $this->tableHeader . $this->tableBody
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
