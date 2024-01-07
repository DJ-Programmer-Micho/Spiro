<?php

namespace App\Notifications\Fin;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramUserNew extends Notification
{
    protected $addBy;
    protected $c_id;
    protected $userName;
    protected $roleName;
    protected $jobTitle;
    protected $avatar;
    protected $tele_id;

    public function __construct($addBy, $c_id, $userName, $roleName, $jobTitle, $avatar, $tele_id)
    {
        $this->addBy = $addBy;
        $this->c_id = $c_id;
        $this->userName = $userName;
        $this->roleName = $roleName;
        $this->jobTitle = $jobTitle;
        $this->avatar = $avatar;
        $this->tele_id = $tele_id;
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
       ->content("*" . 'USER ADDED' . "*\n"
       . "*" .'-----------------'."*\n" 
       . "*" .'Added By: '. $this->addBy . "*\n"
       . "*" .'USER-ID: #USR-'. $this->c_id . "*\n"
       . "*" .'-----------------'."*\n"
       . "*" .'Name: '. $this->userName . "*\n"
       . "*" .'Role: '. $this->roleName . "*\n"
       . "*" .'Job: '. $this->jobTitle . "*\n"
       . "*" . env('APP_URL').'avatars/'.$this->avatar . "*\n"
        );
    }
    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
