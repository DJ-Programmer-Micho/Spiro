<?php

namespace App\Notifications\Edt;

use Illuminate\Notifications\Notification;
use Illuminate\Validation\Rules\Exists;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramInvoiceShort extends Notification
{
    protected $addBy;
    protected $i_id;
    protected $clentName;
    protected $status;

    protected $old_invoice_data;
    protected $telq_id;

    public function __construct($addBy, $i_id, $clentName, $status, $old_invoice_data, $telq_id)
    {
        $this->addBy = $addBy;
        $this->i_id = $i_id;
        $this->clentName = $clentName;
        $this->status = $status;
        $this->old_invoice_data = $old_invoice_data;
        $this->telq_id = $telq_id;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        if(isset($this->old_invoice_data['status'])) {
            $this->old_invoice_data['status'] = $this->old_invoice_data['status'] == 0 ?  "DeActive" : "Active";
        }
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#INV-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'INVOICE UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated By: '. $this->addBy . "*\n"
        . "*" .'INVOICE-ID: #INV-'. $this->i_id . "*\n"
        . "*" .'-----------------'."*\n";

        $content .= "*" . 'Client Name: '. $this->clentName . "*\n";
    
        if(isset($this->old_invoice_data['status'])) {
            if ($this->status !== $this->old_invoice_data['status']) {
                $content .= "*" . 'Status Changed: '. $this->old_invoice_data['status'] . ' ➡️ ' . $this->status . "*\n";
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
