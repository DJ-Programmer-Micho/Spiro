<?php

namespace App\Notifications\Edt;


use App\Models\User;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramAttendNew extends Notification
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
    protected $tele_id;

    public function __construct($a_id, $user_id, $jobTitle, $startTime, $endTime, $duration, $date, $tele_id)
    {
        $this->a_id = $a_id;
        $this->user_id = $user_id;
        $this->jobTitle = $jobTitle;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->duration = $duration;
        $this->date = $date;
        $this->tele_id = $tele_id;

        $this->user_name = User::where('id',$user_id)->first()->name;
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

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content("*" . 'USER ATTENDANCE ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'Added By: '. $this->auth . "*\n"
       . "*" .'USER-ID: #EMP-'. $this->a_id . "*\n"
       . "*" .'DATE:' . $this->date . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Name: '. $this->user_name . "*\n"
       . "*" .'Job Title: '. $this->jobTitle . "*\n"
       . "*" .'Start Time: '. $this->startTime . "*\n"
       . "*" .'End Time: '. $this->endTime . "*\n"
       . "*" .'Duration: '. $this->duration . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
