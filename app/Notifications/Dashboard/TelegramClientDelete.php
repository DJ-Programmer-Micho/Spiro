<?php

namespace App\Notifications\Dashboard;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramClientDelete extends Notification
{
    protected $c_id;
    protected $companyName;
    protected $clientName;
    protected $tele_id;

    public function __construct($c_id, $companyName, $clientName, $tele_id)
    {
        $this->c_id = $c_id;
        $this->companyName = $companyName;
        $this->clientName = $clientName;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#CLI-" . rand(10, 99);
        $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'CLIENT DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'COMPANY-ID: '. $registrationId . '-'. $this->c_id .'-' . $registration3Id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Company Name: '. $this->companyName . "*\n"
       . "*" .'Client Name: '. $this->clientName . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
