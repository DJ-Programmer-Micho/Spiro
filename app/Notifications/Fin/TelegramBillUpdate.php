<?php

namespace App\Notifications\Fin;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramBillUpdate extends Notification
{
    protected $addBy;
    protected $b_id;
    protected $billName;
    protected $cost_dollar;
    protected $cost_iraqi;
    protected $description;
    protected $status;

    protected $old_bill_data;
    protected $tele_id;

    public function __construct($addBy, $b_id, $billName, $cost_dollar, $cost_iraqi, $description, $status, $old_bill_data, $tele_id)
    {
        $this->addBy = $addBy;
        $this->b_id = $b_id;
        $this->billName = $billName;
        $this->cost_dollar = $cost_dollar;
        $this->cost_iraqi = $cost_iraqi;
        $this->description = $description;
        $this->status = $status;
        $this->old_bill_data = $old_bill_data;
        $this->tele_id = $tele_id;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->old_bill_data['status'] = $this->old_bill_data['status'] == 0 ?  "DeActive" : "Active";
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#BIL-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'BILL UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated By: '. $this->addBy . "*\n"
        . "*" .'BILL-ID: #BIL-'. $this->b_id . "*\n"
        . "*" .'-----------------'."*\n";


        if ($this->billName !== $this->old_bill_data['billName']) {
            $content .= "*" . 'Name Changed: '. $this->old_bill_data['billName'] . ' ➡️ ' . $this->billName . "*\n";
        }

        if ($this->cost_dollar !== $this->old_bill_data['cost_dollar']) {
            $content .= "*" . 'Cost Changed: $'. $this->old_bill_data['cost_dollar'] . ' ➡️ $' . $this->cost_dollar . "*\n";
        }

        if ($this->cost_iraqi !== $this->old_bill_data['cost_iraqi']) {
            $content .= "*" . 'Cost Changed: '. $this->old_bill_data['cost_iraqi'] . 'IQD ➡️ ' . $this->cost_iraqi . 'IQD' . "*\n";
        }
        
        if ($this->description !== $this->old_bill_data['description']) {
            $content .= "*" . 'Description Changed: '. $this->old_bill_data['description'] . ' ➡️ ' . $this->description . "*\n";
        }
        
        if ($this->status !== $this->old_bill_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_bill_data['status'] . ' ➡️ ' . $this->status . "*\n";
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
