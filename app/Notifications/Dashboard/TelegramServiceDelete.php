<?php

namespace App\Notifications\Dashboard;


use App\Models\Branch;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramServiceDelete extends Notification
{
    protected $s_id;
    protected $branch_id;
    protected $branch_name;
    protected $serviceCode;
    protected $serviceName;
    protected $tele_id;

    public function __construct($s_id, $branch_id, $serviceCode, $serviceName, $tele_id)
    {
        $this->s_id = $s_id;
        $this->branch_id = $branch_id;
        $this->serviceCode = $serviceCode;
        $this->serviceName = $serviceName;
        $this->tele_id = $tele_id;

        $this->branch_name = Branch::where('id', $this->branch_id)->first()->branchName;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#BRCH-" . rand(10, 99);
        $registration3Id = rand(100, 999);

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'SERVICE DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'SERVICE-ID: '. $registrationId . '-'. $this->s_id .'-' . $registration3Id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Name: '. $this->serviceName . "*\n"
       . "*" .'Code: '. $this->serviceCode . "*\n"
       . "*" .'Branch: '. $this->branch_name . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
