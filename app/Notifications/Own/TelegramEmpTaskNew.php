<?php

namespace App\Notifications\Own;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\EmpTask;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramEmpTaskNew extends Notification
{
    protected $t_id;
    protected $invoiceId;
    protected $arrTasks = [];
    protected $gProgress;
    protected $taskStatus;

    protected $clientName;
    protected $title;
    protected $invoiceDate;
    protected $taskData;

    protected $tableHeader;
    protected $tableBody;

    protected $tele_id;

    public function __construct($t_id, $invoiceId, $arrTasks, $gProgress, $taskStatus, $tele_id)
    {

        $this->t_id = $t_id;
        $this->invoiceId = $invoiceId;
        $this->arrTasks = $arrTasks;
        $this->gProgress = $gProgress;
        $this->taskStatus = $taskStatus;

        $this->taskData = EmpTask::where('id', $this->t_id)->first();

        $this->clientName = $this->taskData->invoice->client->client_name;
        $this->title = $this->taskData->invoice->description;
        $this->invoiceDate = $this->taskData->invoice->invoice_date;

        $this->tele_id = $tele_id;


        // $this->tableHeader = "*Service Code | Service Name | Cost ($) | Cost (IQD) | QTY | Total ($) | Total (IQD)*\n";
        $userNames = $this->getUserNames($this->arrTasks);
        $taskOptionNames = $this->getTaskOptionNames($this->arrTasks);
        $this->tableHeader = "*# | Name | Task | Start Date | End Date | Progress*\n";
        $this->tableBody = collect($this->arrTasks)->map(function ($task, $index) use ($userNames, $taskOptionNames) {
            return sprintf(
                "*%d | %s | %s | %s | %s | %s *",
                $index + 1,
                $userNames[$task['name']],  
                $taskOptionNames[$task['task']],
                $task['start_date'], 
                $task['end_date'], 
                $task['progress'] . '%', 
            );
        })->implode("\n");
        
    }

    private function getUserNames($tasks)
    {
        $userIds = collect($tasks)->pluck('name')->unique()->toArray();

        // Fetch user names from the database
        $userNames = User::whereIn('id', $userIds)->pluck('name', 'id')->toArray();

        return $userNames;
    }

    private function getTaskOptionNames($tasks)
    {
        $taskOptionIds = collect($tasks)->pluck('task')->unique()->toArray();

        // Fetch task option names from the database
        $taskOptionNames = Task::whereIn('id', $taskOptionIds)->pluck('task_option', 'id')->toArray();

        return $taskOptionNames;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // $registrationId = "#TSK-" . rand(10, 99);
        // $registration3Id = rand(100, 999);
        $content = "*" . 'TASK ADDED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'TASK-ID: #TSK-' . $this->t_id . "*\n"
        . "*" .'-----------------'."*\n"
        . "*" .'Title: '. $this->title . "*\n"
        . "*" .'Client: '. $this->clientName . "*\n"
        . "*" .'Date: '.  $this->invoiceDate . "*\n"
        . "*" .'------- Status -------'."*\n"
        . "*" .'Task Status: '.  $this->taskStatus . "*\n"
        . "*" .'Progress: '.  $this->gProgress . "*\n"
        . "*" .'------- Table -------'."*\n"
        . $this->tableHeader . $this->tableBody;

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
