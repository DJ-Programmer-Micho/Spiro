<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramInvoiceDelete extends Notification
{
    protected $i_id;
    protected $tele_id;

    public function __construct($i_id, $tele_id)
    {
        $this->i_id = $i_id;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#INV-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'INVOICE DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'INVOICE-ID: #INV-' . $this->i_id . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
