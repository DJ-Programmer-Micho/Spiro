<?php

namespace App\Notifications\Fin;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramExpenseNew extends Notification
{
    protected $addBy;
    protected $e_id;
    protected $billName;
    protected $type;
    protected $costDollar;
    protected $costIraqi;
    protected $e_date;
    protected $tele_id;

    public function __construct($addBy, $e_id, $billName, $type, $costDollar, $costIraqi, $e_date, $tele_id)
    {
        $this->addBy = $addBy;
        $this->e_id = $e_id;
        $this->billName = $billName;
        $this->type = $type;
        $this->costDollar = $costDollar;
        $this->costIraqi = $costIraqi;
        $this->e_date = $e_date;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#EXP-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'Expense ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'Added By: '. $this->addBy . "*\n"
       . "*" .'EXPENSE-ID: #EXP-'. $this->e_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Bill Name: '. $this->billName . "*\n"
       . "*" .'expense Type: '. $this->type . "*\n"
       . "*" .'Dollar Cost: $'. number_format($this->costDollar). "*\n"
       . "*" .'Iraqi Cost: '. number_format($this->costIraqi) . 'IQD' . "*\n"
       . "*" .'Date: '. $this->e_date . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
