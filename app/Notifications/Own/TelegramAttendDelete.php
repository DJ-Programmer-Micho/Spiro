<?php

namespace App\Notifications\Own;


use App\Models\User;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramAttendDelete extends Notification
{
    protected $a_id;
    protected $user_id;
    protected $user_name;
    protected $date;
    protected $tele_id;

    public function __construct($a_id, $user_id, $date, $tele_id)
    {
        $this->a_id = $a_id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->tele_id = $tele_id;

        $this->user_name = User::find($user_id)->first()->name;

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
       ->content("*" . 'ATTENDANCE DELETED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'USER-ID: #EMP-'. $this->a_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'ATTENDANCE: '. $this->date . "*\n"
       . "*" .'EMP Name: '. $this->user_name . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
