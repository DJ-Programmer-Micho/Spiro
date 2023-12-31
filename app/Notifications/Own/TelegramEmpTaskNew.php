<?php

namespace App\Notifications\Own;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramEmpTaskNew extends Notification
{
    protected $c_id;
    protected $dateCash;
    protected $invoiceId;
    protected $arrPayments = [];
    protected $dueDollar;
    protected $dueIraqi;
    protected $totalDollar;
    protected $totalIraqi;

    protected $desc;
    protected $exchangeRate;
    protected $invoiceData;



    protected $clientName;

    protected $tableHeader;
    protected $tableBody;

    protected $tele_id;

    public function __construct($c_id, $dateCash, $invoiceId, $arrPayments, $dueDollar, $totalDollar, $dueIraqi, $totalIraqi, $tele_id)
    {

        $this->c_id = $c_id;
        $this->dateCash = $dateCash;
        $this->invoiceId = $invoiceId;
        $this->arrPayments = $arrPayments;

        $this->dueDollar = $dueDollar;
        $this->totalDollar = $totalDollar;
        $this->dueIraqi = $dueIraqi;
        $this->totalIraqi = $totalIraqi;

        $this->invoiceData = Invoice::where('id', $this->invoiceId)->first();

        $this->clientName = $this->invoiceData->client->client_name;
        $this->desc = $this->invoiceData->description;
        $this->exchangeRate = $this->invoiceData->exchange_rate;

        $this->tele_id = $tele_id;


        // $this->tableHeader = "*Service Code | Service Name | Cost ($) | Cost (IQD) | QTY | Total ($) | Total (IQD)*\n";
        $this->tableHeader = "*Index | Date | Paid ($) | Paid (IQD)*\n";
        $this->tableBody = collect($this->arrPayments)->map(function ($payment, $index) {
            return sprintf(
                "*%d | %s | $ %s | %s IQD*",
                $index + 1,
                $payment['payment_date'],  // Assuming payment_date is the correct key
                number_format($payment['paymentAmountDollar']),
                number_format($payment['paymentAmountIraqi'])
            );
        })->implode("\n");
        
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#CR-" . rand(10, 99);
        $registration3Id = rand(100, 999);
        $content = "*" . 'Cash Reciept ADDED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Cash Reciept-ID: '. $registrationId . '-'. $this->c_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n"
        . "*" .'Date: '.  $this->dateCash . "*\n"
        . "*" .'Client: '. $this->clientName . "*\n"
        . "*" .'Description: '. $this->desc . "*\n"
        . "*" .'Exchange Rate: $1 ~ '. $this->exchangeRate . " IQD *\n"
        . "*" .'--'."*\n"
        . "*" .'Total Cost ($): $'. number_format($this->dueIraqi). "*\n"
        . "*" .'Due ($): $'. number_format($this->dueDollar). "*\n"
        . "*" .'--'."*\n"
        . "*" .'Total Cost (IQD): '. number_format($this->totalIraqi) . ' IQD' . "*\n"
        . "*" .'Due (IQD): '. number_format($this->totalDollar) . ' IQD' . "*\n"
        . "*" .'------- Table -------'."*\n"
        . $this->tableHeader . $this->tableBody;

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
