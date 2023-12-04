<?php

namespace App\Notifications\Dashboard;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramBranchUpdate extends Notification
{
    protected $b_id;
    protected $branchName;
    protected $branchManager;
    protected $description;

    protected $old_branch_data;
    protected $tele_id;

    public function __construct($b_id, $branchName, $branchManager, $description, $old_branch_data, $tele_id)
    {
        $this->b_id = $b_id;
        $this->branchName = $branchName;
        $this->branchManager = $branchManager;
        $this->description = $description;
        $this->old_branch_data = $old_branch_data;
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

        $content = "*" . 'BRANCH UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'BRANCH-ID: '. $registrationId . '-'. $this->b_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n";

        
        if ($this->branchName !== $this->old_branch_data['branchName']) {
            $content .= "*" . 'Branch Name Changed: '. $this->old_branch_data['branchName'] . ' ➡️ ' . $this->branchName . "*\n";
        }
        
        if ($this->branchManager !== $this->old_branch_data['branchManager']) {
            $content .= "*" . 'Branch Manager Changed: '. $this->old_branch_data['branchManager'] . ' ➡️ ' . $this->branchManager . "*\n";
        }
        
        if ($this->description !== $this->old_branch_data['description']) {
            $content .= "*" . 'Description Changed: '. $this->old_branch_data['description'] . ' ➡️ ' . $this->description . "*\n";
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
