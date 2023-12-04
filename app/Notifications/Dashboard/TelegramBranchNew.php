<?php

namespace App\Notifications\Dashboard;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramBranchNew extends Notification
{
    protected $b_id;
    protected $branchName;
    protected $branchManager;
    protected $tele_id;

    public function __construct($b_id, $branchName, $branchManager, $tele_id)
    {
        $this->b_id = $b_id;
        $this->branchName = $branchName;
        $this->branchManager = $branchManager;
        $this->tele_id = $tele_id;
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
       ->content("*" . 'BRANCH ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'BRANCH-ID: '. $registrationId . '-'. $this->b_id .'-' . $registration3Id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Branch Name: '. $this->branchName . "*\n"
       . "*" .'Branch Manager: '. $this->branchManager . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
