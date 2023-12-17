<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramQuotationDelete extends Notification
{
    protected $q_id;
    protected $tele_id;

    public function __construct($q_id, $tele_id)
    {
        $this->s_id = $q_id;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#QUO-" . rand(10, 99);
        $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'QUOTATION DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'QUOTATION-ID: '. $registrationId . '-'. $this->s_id .'-' . $registration3Id . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
