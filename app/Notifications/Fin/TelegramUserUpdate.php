<?php

namespace App\Notifications\Fin;


use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramUserUpdate extends Notification
{
    protected $addBy;
    protected $u_id;
    protected $name;
    protected $email;
    protected $password;
    protected $role;
    protected $status;
    protected $jobTitle;
    protected $nationalId;
    protected $actualEmail;
    protected $phoneNumberOne;
    protected $phoneNumberTwo;
    protected $salaryDollar;
    protected $salaryIraqi;
    protected $filename;

    protected $old_pass;
    protected $new_pass;


    protected $old_user_data;
    protected $tele_id;

    public function __construct(
        $addBy, $u_id, $name, $email, $password, $role, $status, $jobTitle, $nationalId, $actualEmail,$phoneNumberOne,$phoneNumberTwo,$salaryDollar,$salaryIraqi,$filename, $old_user_data, $tele_id)
    {
        $this->addBy = $addBy;
        $this->u_id = $u_id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
        $this->jobTitle = $jobTitle;
        $this->nationalId = $nationalId;
        $this->actualEmail = $actualEmail;
        $this->phoneNumberOne = $phoneNumberOne;
        $this->phoneNumberTwo = $phoneNumberTwo;
        $this->salaryDollar = $salaryDollar;
        $this->salaryIraqi = $salaryIraqi;
        $this->filename = $filename;

        $this->old_user_data = $old_user_data;
        $this->tele_id = $tele_id;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->old_user_data['status'] = $this->old_user_data['status'] == 0 ?  "DeActive" : "Active";

        if( $this->role == 1) {
            $this->role = 'Admin';
        } else if ( $this->role == 2){
            $this->role = 'Editor';
        } else if  ($this->role == 3) {
            $this->role = 'Finance';
        } else {
            $this->role = 'Employee';
        }

        if( $this->old_user_data['role'] == 1) {
            $this->old_user_data['role'] = 'Admin';
        } else if ( $this->old_user_data['role'] == 2){
            $this->old_user_data['role'] = 'Editor';
        } else if  ($this->old_user_data['role'] == 3) {
            $this->old_user_data['role'] = 'Finance';
        } else {
            $this->old_user_data['role'] = 'Employee';
        }

        $this->old_pass = str_repeat('*', strlen($this->old_user_data['password']) - 4) . substr($this->old_user_data['password'], -4);
        $this->new_pass = str_repeat('*', strlen($this->password) - 4) . substr($this->password, -4);
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#USR-" . rand(10, 99);
        // $registration3Id = rand(100, 999);

        $content = "*" . 'USER UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Updated By: ' . $this->addBy . "*\n"
        . "*" .'USER-ID: #USR-'.  $this->u_id . "*\n"
        . "*" .'-----------------'."*\n";
        
        if ($this->name !== $this->old_user_data['name']) {
            $content .= "*" . 'Name Changed: '. $this->old_user_data['name'] . ' ➡️ ' . $this->name . "*\n";
        }
        
        if ($this->email !== $this->old_user_data['email']) {
            $content .= "*" . 'Email Address Changed: '. $this->old_user_data['email'] . ' ➡️ ' . $this->email . "*\n";
        }

        if ($this->password !== $this->old_user_data['password']) {
            $content .= "* Password Changed: " . $this->old_pass . ' ➡️ ' . $this->new_pass . " *\n";
        }
        
        if ($this->role !== $this->old_user_data['role']) {
            $content .= "*" . 'Role Changes: '. $this->old_user_data['role'] . ' ➡️ ' . $this->role . "*\n";
        }

        if ($this->status !== $this->old_user_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_user_data['status'] . ' ➡️ ' . $this->status . "*\n";
        }
        if ($this->jobTitle !== $this->old_user_data['jobTitle']) {
            $content .= "*" . 'jobTitle Changed: '. $this->old_user_data['jobTitle'] . ' ➡️ ' . $this->jobTitle . "*\n";
        }
        if ($this->nationalId !== $this->old_user_data['nationalId']) {
            $content .= "*" . 'National Id Changed: '. $this->old_user_data['nationalId'] . ' ➡️ ' . $this->nationalId . "*\n";
        }
        if ($this->actualEmail !== $this->old_user_data['actualEmail']) {
            $content .= "*" . 'Personal Email Changed: '. $this->old_user_data['actualEmail'] . ' ➡️ ' . $this->actualEmail . "*\n";
        }
        if ($this->phoneNumberOne !== $this->old_user_data['phoneNumberOne']) {
            $content .= "*" . 'Phone no.1 Changed: '. $this->old_user_data['phoneNumberOne'] . ' ➡️ ' . $this->phoneNumberOne . "*\n";
        }

        if ($this->phoneNumberTwo !== $this->old_user_data['phoneNumberTwo']) {
            $content .= "*" . 'Phone no.2 Changed: '. $this->old_user_data['phoneNumberTwo'] . ' ➡️ ' . $this->phoneNumberTwo . "*\n";
        }

        if ($this->salaryDollar !== $this->old_user_data['salaryDollar']) {
            $content .= "*" . 'Salary in ($) Changed: $'. $this->old_user_data['salaryDollar'] . ' ➡️ $' . $this->salaryDollar . "*\n";
        }

        if ($this->salaryIraqi !== $this->old_user_data['salaryIraqi']) {
            $content .= "*" . 'Salary in (IQD) Changed: '. $this->old_user_data['salaryIraqi'] . 'IQD ➡️ ' . $this->salaryIraqi . 'IQD' . "*\n";
        }

        if ($this->filename !== $this->old_user_data['avatar']) {
            $content .= "*" . 'Image Updated To: '. env('APP_URL').'avatars/'.$this->filename . "*\n";
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
