<?php

namespace App\Notifications\Dashboard;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramClientUpdate extends Notification
{
    protected $c_id;
    protected $companyName;
    protected $clientName;
    protected $email;
    protected $address;
    protected $city;
    protected $country;
    protected $zipcode;
    protected $website;
    protected $phoneOne;
    protected $phoneTwo;

    protected $old_client_data;
    protected $tele_id;

    public function __construct($c_id, $companyName, $clientName, $email, $address, $city, $country, $zipcode, $website, $phoneOne, $phoneTwo, $old_client_data, $tele_id)
    {
        $this->c_id = $c_id;
        $this->companyName = $companyName;
        $this->clientName = $clientName;
        $this->email = $email;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->zipcode = $zipcode;
        $this->website = $website;
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
        $registrationId = "#CLI-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'CLIENT UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'COMPANY-ID: '. $registrationId . '-'. $this->c_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n";

        
        if ($this->companyName !== $this->old_client_data['companyName']) {
            $content .= "*" . 'Company Name Changed: '. $this->old_client_data['companyName'] . ' ➡️ ' . $this->companyName . "*\n";
        }
        
        if ($this->clientName !== $this->old_client_data['clientName']) {
            $content .= "*" . 'Client Name Changed: '. $this->old_client_data['clientName'] . ' ➡️ ' . $this->clientName . "*\n";
        }
        
        if ($this->email !== $this->old_client_data['email']) {
            $content .= "*" . 'Email Address Changed: '. $this->old_client_data['email'] . ' ➡️ ' . $this->email . "*\n";
        }
        
        if ($this->city !== $this->old_client_data['city']) {
            $content .= "*" . 'City Changed: '. $this->old_client_data['city'] . ' ➡️ ' . $this->city . "*\n";
        }
        
        if ($this->address !== $this->old_client_data['address']) {
            $content .= "*" . 'Address Changed: '. $this->old_client_data['address'] . ' ➡️ ' . $this->address . "*\n";
        }

        if ($this->zipcode !== $this->old_client_data['zipcode']) {
            $content .= "*" . 'Zip Code Changed: '. $this->old_client_data['zipcode'] . ' ➡️ ' . $this->zipcode . "*\n";
        }

        if ($this->phoneOne !== $this->old_client_data['phoneOne']) {
            $content .= "*" . 'Phone no.1 Changed: '. $this->old_client_data['phoneOne'] . ' ➡️ ' . $this->phoneOne . "*\n";
        }

        if ($this->phoneTwo !== $this->old_client_data['phoneTwo']) {
            $content .= "*" . 'Phone no.2 Changed: '. $this->old_client_data['phoneTwo'] . ' ➡️ ' . $this->phoneTwo . "*\n";
        }

        if ($this->website !== $this->old_client_data['website']) {
            $content .= "*" . 'website Changed: '. $this->old_client_data['website'] . ' ➡️ ' . $this->website . "*\n";
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
