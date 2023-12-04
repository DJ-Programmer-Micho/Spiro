<?php

namespace App\Notifications\Dashboard;


use App\Models\Branch;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramServiceUpdate extends Notification
{
    protected $s_id;
    protected $branch_id;
    protected $branch_name;
    protected $branch_name_old;
    protected $serviceCode;
    protected $serviceName;
    protected $serviceDescription;
    protected $serviceCost;

    protected $old_service_data;
    protected $tele_id;

    public function __construct($s_id, $branch_id, $serviceCode, $serviceName, $serviceDescription, $serviceCost, $old_service_data, $tele_id)
    {
        $this->s_id = $s_id;
        $this->branch_id = $branch_id;
        $this->serviceCode = $serviceCode;
        $this->serviceName = $serviceName;
        $this->serviceDescription = $serviceDescription;
        $this->serviceCost = $serviceCost;
        $this->old_service_data = $old_service_data;
        $this->tele_id = $tele_id;

        $this->branch_name_old = Branch::where('id', $old_service_data['branch_id'])->first()->branchName;
        $this->branch_name = Branch::where('id', $this->branch_id)->first()->branchName;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#SER-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'SERVICE UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'SERVICE-ID: '. $registrationId . '-'. $this->s_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n";

        
        if ($this->branch_id !== $this->old_service_data['branch_id']) {
            $content .= "*" . 'Branch Changed: '. $this->branch_name_old . ' ➡️ ' . $this->branch_name . "*\n";
        }

        if ($this->serviceCode !== $this->old_service_data['serviceCode']) {
            $content .= "*" . 'Code Changed: '. $this->old_service_data['serviceCode'] . ' ➡️ ' . $this->serviceCode . "*\n";
        }
        
        if ($this->serviceName !== $this->old_service_data['serviceName']) {
            $content .= "*" . 'Name Changed: '. $this->old_service_data['serviceName'] . ' ➡️ ' . $this->serviceName . "*\n";
        }

        if ($this->serviceCost !== $this->old_service_data['cost']) {
            $content .= "*" . 'Cost Changed: $'. $this->old_service_data['cost'] . ' ➡️ $' . $this->serviceCost . "*\n";
        }
        
        if ($this->serviceDescription !== $this->old_service_data['serviceDescription']) {
            $content .= "*" . 'Description Changed: '. $this->old_service_data['serviceDescription'] . ' ➡️ ' . $this->serviceDescription . "*\n";
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
