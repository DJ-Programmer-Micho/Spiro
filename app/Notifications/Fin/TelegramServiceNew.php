<?php

namespace App\Notifications\Fin;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramServiceNew extends Notification
{
    protected $addBy;
    protected $s_id;
    protected $serviceCode;
    protected $serviceName;
    protected $priceDollar;
    protected $priceIraqi;
    protected $tele_id;

    public function __construct($addBy, $s_id, $serviceCode, $serviceName, $priceDollar, $priceIraqi, $tele_id)
    {
        $this->addBy = $addBy;
        $this->s_id = $s_id;
        $this->serviceCode = $serviceCode;
        $this->serviceName = $serviceName;
        $this->priceDollar = $priceDollar;
        $this->priceIraqi = $priceIraqi;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#SER-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'SERVICE ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'Added By: '. $this->addBy . "*\n"
       . "*" .'SERVICE-ID: #SER-'. $this->s_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Code: '. $this->serviceCode . "*\n"
       . "*" .'Name: '. $this->serviceName . "*\n"
       . "*" .'Dollar Price: $'. number_format($this->priceDollar). "*\n"
       . "*" .'Iraqi Price: '. number_format($this->priceIraqi) . 'IQD' . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
