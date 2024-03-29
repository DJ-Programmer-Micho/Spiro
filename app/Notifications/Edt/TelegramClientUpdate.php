<?php

namespace App\Notifications\Edt;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramClientUpdate extends Notification
{
    protected $addBy;
    protected $c_id;
    protected $clientName;
    protected $email;
    protected $address;
    protected $city;
    protected $country;
    protected $phoneOne;
    protected $phoneTwo;

    protected $old_client_data;
    protected $tele_id;

    public function __construct($addBy, $c_id, $clientName, $email, $address, $city, $country, $phoneOne, $phoneTwo, $old_client_data, $tele_id)
    {
        $this->addBy = $addBy;
        $this->c_id = $c_id;
        $this->clientName = $clientName;
        $this->email = $email;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->phoneOne = $phoneOne;
        $this->phoneTwo = $phoneTwo;

        $this->old_client_data = $old_client_data;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#CLI-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'CLIENT UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated By: '. $this->addBy . "*\n"
        . "*" .'CLIENT-ID: #CLI-' . $this->c_id . "*\n"
        . "*" .'-----------------'."*\n";
        
        if ($this->clientName !== $this->old_client_data['clientName']) {
            $content .= "*" . 'Client Name Changed: '. $this->old_client_data['clientName'] . ' ➡️ ' . $this->clientName . "*\n";
        }
        
        // if ($this->email !== $this->old_client_data['email']) {
        //     $content .= "*" . 'Email Address Changed: '. $this->old_client_data['email'] . ' ➡️ ' . $this->email . "*\n";
        // }
        
        // if ($this->city !== $this->old_client_data['city']) {
        //     $content .= "*" . 'City Changed: '. $this->old_client_data['city'] . ' ➡️ ' . $this->city . "*\n";
        // }
        
        if ($this->address !== $this->old_client_data['address']) {
            $content .= "*" . 'Address Changed: '. $this->old_client_data['address'] . ' ➡️ ' . $this->address . "*\n";
        }

        if ($this->phoneOne !== $this->old_client_data['phoneOne']) {
            $content .= "*" . 'Phone no.1 Changed: '. $this->old_client_data['phoneOne'] . ' ➡️ ' . $this->phoneOne . "*\n";
        }

        if ($this->phoneTwo !== $this->old_client_data['phoneTwo']) {
            $content .= "*" . 'Phone no.2 Changed: '. $this->old_client_data['phoneTwo'] . ' ➡️ ' . $this->phoneTwo . "*\n";
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
