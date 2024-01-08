<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramEmpTaskShort extends Notification
{
    protected $e_id;
    protected $title;
    protected $status;

    protected $old_expense_data;
    protected $tele_id;

    public function __construct($e_id, $title, $status, $old_expense_data, $tele_id)
    {
    
        $this->e_id = $e_id;
        $this->title = $title;
        $this->status = $status;

        $this->old_expense_data = $old_expense_data;
        $this->tele_id = $tele_id;

        $this->status = $this->status == 0 ?  "Dis-Approved" : "Approved";
        $this->old_expense_data['status'] = $this->old_expense_data['status'] == 0 ?  "Dis-Approved" : "Approved";
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#EMP-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'EMP TASKS UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'EMP TASKS-ID: #TSK-' . $this->e_id . "*\n"
        . "*" .'-----------------'."*\n";

        $content .= "*" . 'Invoice Title: '. $this->title . "*\n";
    

        if ($this->status !== $this->old_expense_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_expense_data['status'] . ' ➡️ ' . $this->status . "*\n";
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
