<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramExpenseUpdate extends Notification
{
    protected $e_id;
    protected $item;
    protected $type;
    protected $description;
    protected $cost_dollar;
    protected $cost_iraqi;
    protected $payed_date;
    protected $status;

    protected $old_expense_data;
    protected $tele_id;

    public function __construct($e_id, $item, $type, $description, $cost_dollar, $cost_iraqi, $payed_date, $status, $old_expense_data, $tele_id)
    {
    
        $this->e_id = $e_id;
        $this->item = $item;
        $this->type = $type;
        $this->description = $description;
        $this->cost_dollar = $cost_dollar;
        $this->cost_iraqi = $cost_iraqi;
        $this->payed_date = $payed_date;
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
        $registrationId = "#EXP-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'EXPENSE UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'EXPENSE-ID: '. $registrationId . '-'. $this->e_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n";


        if ($this->item !== $this->old_expense_data['item']) {
            $content .= "*" . 'Bill Name Changed: '. $this->old_expense_data['item'] . ' ➡️ ' . $this->item . "*\n";
        }

        if ($this->type !== $this->old_expense_data['type']) {
            $content .= "*" . 'Type Changed: '. $this->old_expense_data['type'] . ' ➡️ ' . $this->type . "*\n";
        }

        if ($this->cost_dollar !== $this->old_expense_data['cost_dollar']) {
            $content .= "*" . 'Cost Changed: $'. $this->old_expense_data['cost_dollar'] . ' ➡️ $' . $this->cost_dollar . "*\n";
        }

        if ($this->cost_iraqi !== $this->old_expense_data['cost_iraqi']) {
            $content .= "*" . 'Cost Changed: '. $this->old_expense_data['cost_iraqi'] . 'IQD ➡️ ' . $this->cost_iraqi . 'IQD' . "*\n";
        }
        
        if ($this->payed_date !== $this->old_expense_data['billDate']) {
            $content .= "*" . 'Date Changed: '. $this->old_expense_data['billDate'] . ' ➡️ ' . $this->payed_date . "*\n";
        }

        if ($this->description !== $this->old_expense_data['description']) {
            $content .= "*" . 'Description Changed: '. $this->old_expense_data['description'] . ' ➡️ ' . $this->description . "*\n";
        }
        
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
