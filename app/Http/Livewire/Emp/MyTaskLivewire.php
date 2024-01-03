<?php

namespace App\Http\Livewire\Emp;

use App\Models\EmpTask;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
// use App\Notifications\Dashboard\TelegramBranchNew;
// use App\Notifications\Dashboard\TelegramBranchUpdate;
// use App\Notifications\Dashboard\TelegramBranchDelete;


class MyTaskLivewire extends Component
{
    // use WithPagination; 
    // protected $paginationTheme = 'bootstrap';

    public $groupedTasks;

    public function mount() {
       $this->initializeFilteredTasks();
    } // END FUNCTION OF PAGE LOAD
    
    public $progress_ = [];

    public function initializeFilteredTasks()
    {
    $userId = auth()->id();
    try {
    $this->groupedTasks = EmpTask::where('approved', 0)->get()
        ->map(function ($empTask) use ($userId) {
            $decodedTasks = json_decode($empTask->tasks, true);

            return [
                'id' => $empTask->id,
                'invoice_id' => $empTask->invoice_id,
                'tasks' => array_filter($decodedTasks, function ($task) use ($userId) {
                    return $task['name'] == $userId;
                
                })
            ];
        })
        ->filter(function ($empTask) {
            return !empty($empTask['tasks']);
        })
        ->groupBy('id')
        ->map(function ($group) {
            return collect($group)->pluck('tasks')->toArray();
        });

       // Initialize progress array
       $this->progress_ = [];
       foreach ($this->groupedTasks as $id_index => $group) {
           $taskData = EmpTask::find($id_index);
           foreach ($group as $index => $subgroup) {
               foreach ($subgroup as $sub_index => $sub_task) {
               $this->progress_[$id_index . '_' . $sub_index] = $sub_task['progress'] ?? 0;
           }
           }
       }
        }  catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('An error occurred while sending Notification.')]);
        }
    }
    public function updateTask($id_index, $sub_index)
    {
        try {
            $empTask = EmpTask::find($id_index);
            $tasks = json_decode($empTask->tasks, true);
            $tasks[$sub_index]['progress'] = $this->progress_[$id_index . '_' . $sub_index];
            $empTask->tasks = json_encode($tasks);
            $empTask->save();
            ///////////////////////////
            $sumProgress = 0;
            $gProgress = 0;
            $tempData = json_decode($empTask->tasks, true);
            foreach ($tempData as $task) {
                $sumProgress += $task['progress'];
            }
            $gProgress += $sumProgress /  count($tempData);
            $empTask->progress = $gProgress;
    
            if($gProgress == 100) {
                $empTask->task_status = 'Complete';
            } else if ($gProgress > 0) {
                $empTask->task_status = 'In Process';
            } else {
                $empTask->task_status = 'In Pending';
            }
    
            $empTask->save();
            $this->initializeFilteredTasks();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Task Progress Updated.')]);
        }  catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Task Progress Did Not Update.')]);
        }

    }
    
    public function render()
    {
        return view('livewire.emp.mytask-table',[
            'groupedTasks' => $this->groupedTasks,
        ]);
    } // END FUNCTION OF RENDER
}