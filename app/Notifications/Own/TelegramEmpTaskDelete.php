<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramEmpTaskDelete extends Notification
{
    protected $t_id;
    protected $tele_id;

    public function __construct($t_id, $tele_id)
    {
        $this->t_id = $t_id;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#TSK-" . rand(10, 99);
        $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'TASK DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'TASK-ID: '. $registrationId . '-'. $this->t_id .'-' . $registration3Id . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
