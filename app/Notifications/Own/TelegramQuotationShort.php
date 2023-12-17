<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use Illuminate\Validation\Rules\Exists;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramQuotationShort extends Notification
{
    protected $q_id;
    protected $clentName;
    protected $status;
    protected $quotation_status;

    protected $old_quotation_data;
    protected $telq_id;

    public function __construct($q_id, $clentName, $status, $quotation_status, $old_quotation_data, $telq_id)
    {
        $this->q_id = $q_id;
        $this->clentName = $clentName;
        $this->status = $status;
        $this->quotation_status = $quotation_status;
        $this->old_quotation_data = $old_quotation_data;
        $this->telq_id = $telq_id;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        if(isset($this->old_quotation_data['status'])) {
            $this->old_quotation_data['status'] = $this->old_quotation_data['status'] == 0 ?  "DeActive" : "Active";
        }
        
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#QUO-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'QUOTATION UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'QUOTATION-ID: '. $registrationId . '-'. $this->q_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n";

        $content .= "*" . 'Client Name: '. $this->clentName . "*\n";
    
        if(isset($this->old_quotation_data['status'])) {
            if ($this->status !== $this->old_quotation_data['status']) {
                $content .= "*" . 'Status Changed: '. $this->old_quotation_data['status'] . ' ➡️ ' . $this->status . "*\n";
            }
        }
        
        if(isset($this->old_quotation_data['quotation_status'])) {
            if ($this->quotation_status !== $this->old_quotation_data['quotation_status']) {
                $content .= "*" . 'Quotation Status Changed: '. $this->old_quotation_data['quotation_status'] . ' ➡️ ' . $this->quotation_status . "*\n";
            }
        }

       return TelegramMessage::create()
       ->to($this->telq_id)
       ->content($content);
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
