<?php

namespace App\Notifications\Fin;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramPaymentNew extends Notification
{
    protected $addBy;
    protected $p_id;
    protected $paymentType;
    protected $tele_id;

    public function __construct($addBy, $p_id, $paymentType, $tele_id)
    {
        $this->addBy = $addBy;
        $this->p_id = $p_id;
        $this->paymentType = $paymentType;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#PAY-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'PAYMENT TYPE ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'Added By: '. $this->addBy . "*\n"
       . "*" .'PAYMENT-ID: #PAY-'. $this->p_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Type: '. $this->paymentType . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
