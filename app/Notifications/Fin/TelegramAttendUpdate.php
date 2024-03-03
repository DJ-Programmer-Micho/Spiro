<?php

namespace App\Notifications\Fin;


use App\Models\User;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramAttendUpdate extends Notification
{
    protected $a_id;
    protected $user_id;
    protected $jobTitle;
    protected $startTime;
    protected $endTime;
    protected $duration;
    protected $date;
    protected $user_name;

    protected $auth;

    protected $old_attend_name;
    protected $tele_id;

    public function __construct(
        $a_id, $user_id, $jobTitle, $startTime, $endTime, $duration, $date, $old_attend_name, $tele_id)
    {
        $this->a_id = $a_id;
        $this->user_id = $user_id;
        $this->jobTitle = $jobTitle;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->duration = $duration;
        $this->date = $date;

        $this->old_attend_name = $old_attend_name;
        $this->tele_id = $tele_id;

        $this->user_name = User::where('id',$user_id)->first()->name;
        $this->old_attend_name['select_emp_data'] = User::where('id',$this->old_attend_name['select_emp_data'])->first()->name;

        $this->old_attend_name['endTime'] = $this->old_attend_name['endTime'] ?? 0;

        $this->auth = User::where('id',auth()->id())->first()->name;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#USR-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'EMP ATTENDANCE UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated By: ' . $this->auth . "*\n"
        . "*" .'USER-ID: #EMP-' . $this->a_id . "*\n";
        if ($this->date !== $this->old_attend_name['date']) {
            $content .= "*" . 'Date: '. $this->old_attend_name['date'] . ' ➡️ ' . $this->date . "*\n";
        } else {
            $content .= "*" .'Date: '. $this->date . "*\n";
        }
        $content .= "*" .'-----------------'."*\n";
        
        if ($this->user_name !== $this->old_attend_name['select_emp_data']) {
            $content .= "*" . 'Employee: '. $this->old_attend_name['select_emp_data'] . ' ➡️ ' . $this->user_name . "*\n";
        } else {
            $content .= "*" .'Name: '. $this->user_name . "*\n";
        }
        
        if ($this->jobTitle !== $this->old_attend_name['jobTitle']) {
            $content .= "*" . 'Job Title: '. $this->old_attend_name['jobTitle'] . ' ➡️ ' . $this->jobTitle . "*\n";
        } else {
            $content .= "*" . 'Job Title: '. $this->jobTitle . "*\n";
        }

        if ($this->startTime !== $this->old_attend_name['startTime']) {
            $content .= "* Start Time: " . $this->startTime . ' ➡️ ' . $this->startTime . " *\n";
        }
        
        if ($this->endTime !== $this->old_attend_name['endTime']) {
            $content .= "*" . 'End Time Changes: '. $this->old_attend_name['endTime'] . ' ➡️ ' . $this->endTime . "*\n";
        }

        if ($this->duration !== $this->old_attend_name['duration']) {
            $content .= "*" . 'Duration Changed: '. $this->old_attend_name['duration'] . ' ➡️ ' . $this->duration . "*\n";
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
