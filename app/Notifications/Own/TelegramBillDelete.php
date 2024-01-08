<?php

namespace App\Notifications\Own;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramBillDelete extends Notification
{
    protected $b_id;
    protected $billName;
    protected $tele_id;

    public function __construct($b_id, $billName, $tele_id)
    {
        $this->b_id = $b_id;
        $this->billName = $billName;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#BIL-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'BILL DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'BILL-ID: #BIL-' . $this->b_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Bill Name: '. $this->billName . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
