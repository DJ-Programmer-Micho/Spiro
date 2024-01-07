<?php

namespace App\Notifications\Edt;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramClientNew extends Notification
{
    protected $addBy;
    protected $c_id;
    protected $clientName;
    protected $email;
    protected $address;
    protected $phoneOne;
    protected $tele_id;

    public function __construct($addBy, $c_id, $clientName, $email, $address, $phoneOne, $tele_id)
    {
        $this->addBy = $addBy;
        $this->c_id = $c_id;
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
        // $registrationId = "#CLI-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'CLIENT ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'Added By: '. $this->addBy . "*\n"
       . "*" .'CLIENT-ID: #CLI-' . $this->c_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Name: '. $this->clientName . "*\n"
       . "*" .'Email: '. $this->email . "*\n"
       . "*" .'Phone: '. $this->phoneOne . "*\n"
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
