<?php

namespace App\Notifications\Fin;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramServiceUpdate extends Notification
{
    protected $addBy;
    protected $s_id;
    protected $serviceCode;
    protected $serviceName;
    protected $serviceDescription;
    protected $priceDollar;
    protected $priceIraqi;

    protected $old_service_data;
    protected $tele_id;

    public function __construct($addBy, $s_id, $serviceCode, $serviceName, $serviceDescription, $priceDollar, $priceIraqi, $old_service_data, $tele_id)
    {
        $this->addBy = $addBy;
        $this->s_id = $s_id;
        $this->serviceCode = $serviceCode;
        $this->serviceName = $serviceName;
        $this->serviceDescription = $serviceDescription;
        $this->priceDollar = $priceDollar;
        $this->priceIraqi = $priceIraqi;
        $this->old_service_data = $old_service_data;
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

        $content = "*" . 'SERVICE UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated By: '. $this->addBy . "*\n"
        . "*" .'SERVICE-ID: #SER-'. $this->s_id . "*\n"
        . "*" .'-----------------'."*\n";


        if ($this->serviceCode !== $this->old_service_data['serviceCode']) {
            $content .= "*" . 'Code Changed: '. $this->old_service_data['serviceCode'] . ' ➡️ ' . $this->serviceCode . "*\n";
        }
        
        if ($this->serviceName !== $this->old_service_data['serviceName']) {
            $content .= "*" . 'Name Changed: '. $this->old_service_data['serviceName'] . ' ➡️ ' . $this->serviceName . "*\n";
        }

        if ($this->priceDollar !== $this->old_service_data['priceDollar']) {
            $content .= "*" . 'Cost Changed: $'. $this->old_service_data['priceDollar'] . ' ➡️ $' . $this->priceDollar . "*\n";
        }

        if ($this->priceIraqi !== $this->old_service_data['priceIraqi']) {
            $content .= "*" . 'Cost Changed: '. $this->old_service_data['priceIraqi'] . 'IQD ➡️ ' . $this->priceIraqi . 'IQD' . "*\n";
        }
        
        if ($this->serviceDescription !== $this->old_service_data['serviceDescription']) {
            $content .= "*" . 'Description Changed: '. $this->old_service_data['serviceDescription'] . ' ➡️ ' . $this->serviceDescription . "*\n";
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
