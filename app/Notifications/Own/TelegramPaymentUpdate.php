<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramPaymentUpdate extends Notification
{
    protected $s_id;
    protected $paymentType;
    protected $status;

    protected $old_payment_data;
    protected $tele_id;

    public function __construct($s_id, $paymentType, $status, $old_payment_data, $tele_id)
    {
        $this->s_id = $s_id;
        $this->paymentType = $paymentType;

        $this->old_payment_data = $old_payment_data;
        $this->tele_id = $tele_id;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->old_payment_data['status'] = $this->old_payment_data['status'] == 0 ?  "DeActive" : "Active";

    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#PAY-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'PAYMENT UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'PAYMENT-ID: '. $registrationId . '-'. $this->s_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n";


        if ($this->paymentType !== $this->old_payment_data['paymentType']) {
            $content .= "*" . 'Type Changed: '. $this->old_payment_data['paymentType'] . ' ➡️ ' . $this->paymentType . "*\n";
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
