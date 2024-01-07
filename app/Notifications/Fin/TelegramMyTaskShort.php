<?php

namespace App\Notifications\Fin;

use App\Models\User;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramMyTaskShort extends Notification
{
    protected $addBy;
    protected $e_id;
    protected $title;
    protected $name;
    
    protected $old_progress;
    protected $new_progress;

    protected $tele_id;

    public function __construct($addBy, $e_id, $title, $name, $old_progress, $new_progress, $tele_id)
    {
        $this->addBy = $addBy;
        $this->e_id = $e_id;
        $this->title = $title;
        
        $this->old_progress = $old_progress;
        $this->new_progress = $new_progress;

        $this->name = User::where('id',$name)->first()->name;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $content = "*" . 'TASKS PROGRESS UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated Task By: ' . $this->addBy . "*\n"
        . "*" .'FIN TASKS-ID: #MYT-' . $this->e_id . "*\n"
        . "*" .'-----------------'."*\n";

        $content .= "*" . 'Invoice Title: '. $this->title . "*\n";
        $content .= "*" . 'Employee Name: '. $this->name . "*\n";
        $content .= "*" . 'Task Progress: '. $this->old_progress . '% ➡️ ' .$this->new_progress ."%*\n";
    

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
