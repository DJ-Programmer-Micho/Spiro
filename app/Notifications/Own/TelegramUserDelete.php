<?php

namespace App\Notifications\Own;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramUserDelete extends Notification
{
    protected $c_id;
    protected $userName;
    protected $tele_id;

    public function __construct($c_id, $userName, $tele_id)
    {
        $this->c_id = $c_id;
        $this->userName = $userName;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#USR-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'USER DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'USER-ID: #USR-'. $this->c_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'User Name: '. $this->userName . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
