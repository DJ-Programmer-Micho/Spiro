<?php

namespace App\Notifications\Fin;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramPaymentUpdate extends Notification
{
    protected $addBy;
    protected $p_id;
    protected $paymentType;
    protected $status;

    protected $old_payment_data;
    protected $tele_id;

    public function __construct($addBy, $p_id, $paymentType, $status, $old_payment_data, $tele_id)
    {
        $this->addBy = $addBy;
        $this->p_id = $p_id;
        $this->paymentType = $paymentType;

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
        // $registrationId = "#PAY-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'PAYMENT UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated By: '. $this->addBy . "*\n"
        . "*" .'PAYMENT-ID: #PAY-'. $this->p_id . "*\n"
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
