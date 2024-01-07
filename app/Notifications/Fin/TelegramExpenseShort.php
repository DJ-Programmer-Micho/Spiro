<?php

namespace App\Notifications\Fin;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramExpenseShort extends Notification
{
    protected $addBy;
    protected $e_id;
    protected $item;
    protected $status;

    protected $old_expense_data;
    protected $tele_id;

    public function __construct($addBy, $e_id, $item, $status, $old_expense_data, $tele_id)
    {
        $this->addBy = $addBy;
        $this->e_id = $e_id;
        $this->item = $item;
        $this->status = $status;
        $this->old_expense_data = $old_expense_data;
        $this->tele_id = $tele_id;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->old_expense_data['status'] = $this->old_expense_data['status'] == 0 ?  "DeActive" : "Active";
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#EXP-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'EXPENSE UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated By: '. $this->addBy . "*\n"
        . "*" .'PAYMENT-ID: #EXP-'. $this->e_id . "*\n"
        . "*" .'-----------------'."*\n";

        $content .= "*" . 'Expense Name: '. $this->item . "*\n";
    

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
