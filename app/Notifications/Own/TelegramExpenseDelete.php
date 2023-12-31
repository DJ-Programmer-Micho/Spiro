<?php

namespace App\Notifications\Own;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramExpenseDelete extends Notification
{
    protected $e_id;
    protected $billItem;
    protected $tele_id;

    public function __construct($e_id, $billItem, $tele_id)
    {
        $this->e_id = $e_id;
        $this->billItem = $billItem;
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
       ->content("*" . 'EXPENSE DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'EXPENSE -ID: #EXP-' . $this->e_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'User Name: '. $this->billItem . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
