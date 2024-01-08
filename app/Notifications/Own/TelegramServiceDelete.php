<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramServiceDelete extends Notification
{
    protected $s_id;
    protected $serviceCode;
    protected $serviceName;
    protected $tele_id;

    public function __construct($s_id, $serviceCode, $serviceName, $tele_id)
    {
        $this->s_id = $s_id;
        $this->serviceCode = $serviceCode;
        $this->serviceName = $serviceName;
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
       ->content("*" . 'SERVICE DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'SERVICE-ID: #SER-' . $this->s_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Name: '. $this->serviceName . "*\n"
       . "*" .'Code: '. $this->serviceCode . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
