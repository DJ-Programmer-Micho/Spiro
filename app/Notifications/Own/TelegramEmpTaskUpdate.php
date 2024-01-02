<?php

namespace App\Notifications\Own;

use App\Models\EmpTask;
use App\Models\Service;
use App\Models\Task;
use App\Models\User;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramEmpTaskUpdate extends Notification
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

    protected $old_task_data;
    protected $tele_id;

    public function __construct($t_id, $invoiceId, $arrTasks, $gProgress, $taskStatus,  $old_task_data, $tele_id)
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


        $this->old_task_data = $old_task_data;
        $this->tele_id = $tele_id;

        // $this->status = $this->status == 0 ?  "DeActive" : "Active";
        // $this->old_task_data['taskStatus'] = $this->old_task_data['taskStatus'] == 0 ?  "DeActive" : "Active";
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $registrationId = "#TSK-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'TASK UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'TASK-ID: '. $registrationId . '-'. $this->t_id .'-' . $registration3Id . "*\n"
        . "*" .'-----------------'."*\n"
        . "*" .'Title: '. $this->title . "*\n"
        . "*" .'Client: '. $this->clientName . "*\n"
        . "*" .'Date: '.  $this->invoiceDate . "*\n";


        if ($this->taskStatus !== $this->old_task_data['taskStatus']) {
            $content .= "*" . 'Tasks Changes: '. $this->old_task_data['taskStatus'] . ' ➡️ ' . $this->taskStatus . "*\n";
        }

        if ($this->gProgress !== $this->old_task_data['generalProgress']) {
            $content .= "*" . 'Progress Changed: '. $this->old_task_data['generalProgress'] . ' ➡️ ' . $this->gProgress . "*\n";
        }

        function compareServices($old_task, $new_task) {
            $changes = [];

            foreach ($old_task as $key => $oldValue) {
                if ($oldValue !== $new_task[$key]) {
                    $changes[$key] = [
                        'old' => $oldValue,
                        'new' => $new_task[$key],
                    ];
                }
            }

            return $changes;
        }

        $oldTask = json_decode(json_decode($this->old_task_data['arr_task'], true), true);
        $newTask = $this->arrTasks;

        // $content .= "*" . 'Tasks Changes:' . "*\n";
        // $content .= "*" . '-----------------' . "*\n";

        $maxCount = max(count($oldTask), count($newTask));

        for ($index = 0; $index < $maxCount; $index++) {
            $old_task = $oldTask[$index] ?? null;
            $new_task = $newTask[$index] ?? null;

            if ($old_task && $new_task) {
                // dd($old_task, $new_task);
                // Both arrays have an element at this index, compare them
                $serviceChanges = compareServices($old_task, $new_task);

                // If there are changes, display them
                if (!empty($serviceChanges)) {
                    $old_taskName_2 = Task::find($old_task['task'])->task_option ?? 'Unknown Task';
                    $new_taskName_2 = Task::find($new_task['task'])->task_option ?? 'Unknown Task';

                    $old_empName_2 = User::find($old_task['name'])->name ?? 'Unknown Employee';
                    $new_empName_2 = User::find($new_task['name'])->name ?? 'Unknown Employee';
                    $content .= "*" . '-----------------' . "*\n";
                    $content .= "*" . 'Service at Position ' . ($index + 1) . "*\n";

                    // Display specific changes
                    foreach ($serviceChanges as $key => $change) {
                        if ($key === 'task' || $key === 'name') {
                            $content .= "*" . 'Task Name: ' . ": " . $old_taskName_2 . ' ➡️ ' .$new_taskName_2  . "*\n";
                            $content .= "*" . 'Emp Name: ' . ": " . $old_empName_2 . ' ➡️ ' .$new_empName_2  . "*\n";
                        // } else if ($key === 'name') {
                        //     $content .= "*" . 'Emp Name: ' . ": " . $old_empName_2 . ' ➡️ ' .$new_empName_2  . "*\n";
                        } else {
                            $content .= "*" . ucfirst($key) . ": " . $change['old'] . ' ➡️ ' . $change['new'] . "*\n";
                        }
                    }
                }
            } elseif ($old_task) {
                // Only old array has an element at this index
                $old_serviceName = Task::find($old_task['task'])->task_option ?? 'Unknown Task';
                $content .= "*" . 'Task at Position ' . ($index + 1) . ' ('. $old_serviceName . ') was removed.' . "*\n";
            } elseif ($new_task) {
                // Only new array has an element at this index
                $new_taskName = Task::find($new_task['task'])->task_option ?? 'Unknown Task';
                $new_empName = User::find($new_task['name'])->name ?? 'Unknown Employee';
                $content .= "*" . '-----------------' . "*\n"
                    . "*" . 'Task at Position ' . ($index + 1) . ' was added.' . "*\n"
                    . "*" . 'Emp Name: '.  $new_empName . "*\n"
                    . "*" . 'Task Name: '.  $new_taskName . "*\n"
                    . "*" . 'Start Date: '.  $new_task['start_date'] . "*\n"
                    . "*" . 'End Date: '.  $new_task['end_date'] . "*\n"
                    . "*" . 'Progress: '.  $new_task['progress'] . "*\n";
            }
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
