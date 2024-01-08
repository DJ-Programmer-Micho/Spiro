<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramTaskUpdate extends Notification
{
    protected $s_id;
    protected $taskOption;
    protected $status;

    protected $old_payment_data;
    protected $tele_id;

    public function __construct($s_id, $taskOption, $status, $old_payment_data, $tele_id)
    {
        $this->s_id = $s_id;
        $this->taskOption = $taskOption;

        $this->old_payment_data = $old_payment_data;
        $this->tele_id = $tele_id;

        $this->status = $status == 0 ?  "DeActive" : "Active";
        $this->old_payment_data['status'] = $this->old_payment_data['status'] == 0 ?  "DeActive" : "Active";

    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#TSK-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'TASK OPTION UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'TASK-ID: #TSK-'. $this->s_id . "*\n"
        . "*" .'-----------------'."*\n";

        if ($this->taskOption !== $this->old_payment_data['taskOption']) {
            $content .= "*" . 'Type Changed: '. $this->old_payment_data['taskOption'] . ' ➡️ ' . $this->taskOption . "*\n";
        }
        
        if ($this->status !== $this->old_payment_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_payment_data['status'] . ' ➡️ ' . $this->status . "*\n";
        }
        

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content($content);
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
