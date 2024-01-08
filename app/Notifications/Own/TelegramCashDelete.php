<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramCashDelete extends Notification
{
    protected $c_id;
    protected $tele_id;

    public function __construct($c_id, $tele_id)
    {
        $this->c_id = $c_id;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#CR-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'CASH RECIEPT DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'CASH RECIEPT-ID: #CR-' . $this->c_id . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
