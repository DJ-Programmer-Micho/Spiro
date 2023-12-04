<?php

namespace App\Notifications\Dashboard;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramClientNew extends Notification
{
    protected $c_id;
    protected $companyName;
    protected $clientName;
    protected $email;
    protected $address;
    protected $phoneOne;
    protected $tele_id;

    public function __construct($c_id, $companyName, $clientName, $email, $address, $phoneOne, $tele_id)
    {
        $this->c_id = $c_id;
        $this->companyName = $companyName;
        $this->clientName = $clientName;
        $this->email = $email;
        $this->address = $address;
        $this->phoneOne = $phoneOne;
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
       ->content("*" . 'CLIENT ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'COMPANY-ID: '. $registrationId . '-'. $this->c_id .'-' . $registration3Id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Company Name: '. $this->companyName . "*\n"
       . "*" .'Client Name: '. $this->clientName . "*\n"
       . "*" .'Email Address: '. $this->email . "*\n"
       . "*" .'Phone Number: '. $this->phoneOne . "*\n"
       . "*" .'Address: '. $this->address . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
