<?php

namespace App\Notifications\Own;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramBillNew extends Notification
{
    protected $b_id;
    protected $billName;
    protected $costDollar;
    protected $costIraqi;
    protected $tele_id;

    public function __construct($b_id, $billName, $costDollar, $costIraqi, $tele_id)
    {
        $this->b_id = $b_id;
        $this->billName = $billName;
        $this->costDollar = $costDollar;
        $this->costIraqi = $costIraqi;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#BIL-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'Bill ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'BILL-ID: #BIL-' . $this->b_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Name: '. $this->billName . "*\n"
       . "*" .'Dollar Cost: $'. number_format($this->costDollar). "*\n"
       . "*" .'Iraqi Cost: '. number_format($this->costIraqi) . 'IQD' . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
