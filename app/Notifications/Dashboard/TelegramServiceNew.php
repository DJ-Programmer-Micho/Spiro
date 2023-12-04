<?php

namespace App\Notifications\Dashboard;


use App\Models\Branch;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramServiceNew extends Notification
{
    protected $s_id;
    protected $branch_id;
    protected $branch_name;
    protected $serviceCode;
    protected $serviceName;
    protected $cost;
    protected $tele_id;

    public function __construct($s_id, $branch_id, $serviceCode, $serviceName, $cost, $tele_id)
    {
        $this->s_id = $s_id;
        $this->branch_id = $branch_id;
        $this->serviceCode = $serviceCode;
        $this->serviceName = $serviceName;
        $this->cost = $cost;
        $this->tele_id = $tele_id;

        $this->branch_name = Branch::where('id', $this->branch_id)->first()->branchName;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#SER-" . rand(10, 99);
        $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'SERVICE ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'SERVICE-ID: '. $registrationId . '-'. $this->s_id .'-' . $registration3Id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Branch Name: '. $this->branch_name . "*\n"
       . "*" .'Code: '. $this->serviceCode . "*\n"
       . "*" .'Name: '. $this->serviceName . "*\n"
       . "*" .'Cost: '. $this->cost . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
