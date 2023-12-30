<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramTaskDelete extends Notification
{
    protected $p_id;
    protected $taskOption;
    protected $serviceName;
    protected $tele_id;

    public function __construct($p_id, $taskOption, $tele_id)
    {
        $this->p_id = $p_id;
        $this->taskOption = $taskOption;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#TSK -" . rand(10, 99);
        $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'TASK OPTION DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'TASK-ID: '. $registrationId . '-'. $this->p_id .'-' . $registration3Id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Name: '. $this->taskOption . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
