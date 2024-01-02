<?php

namespace App\Http\Livewire\Emp;

use App\Models\Task;
use App\Models\Branch;
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

    // public function initializeFilteredTasks()
    // {
    //     $userId = auth()->id();
    
    //     $tasks = EmpTask::get()
    //         ->map(function ($empTask) use ($userId) {
    //             $decodedTasks = json_decode($empTask->tasks, true);
    
    //             return [
    //                 'id' => $empTask->id,
    //                 'invoice_id' => $empTask->invoice_id, // Add this line to include invoice_id
    //                 'tasks' => array_filter($decodedTasks, function ($task) use ($userId) {
    //                     return $task['name'] == $userId;
    //                 })
    //             ];
    //         })
    //         ->filter(function ($empTask) {
    //             return !empty($empTask['tasks']);
    //         })
    //         ->groupBy('id')
    //         ->map(function ($group) {
    //             return collect($group)->pluck('tasks')->flatten(1)->toArray();
    //         });
    
    //     $this->groupedTasks = $tasks;
    // }
    
    public $progress_ = [];

    public function initializeFilteredTasks()
    {
    $userId = auth()->id();
    $this->groupedTasks = EmpTask::get()
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

    //    dd( $this->progress_);
    }
    
    // public function getTaskData($id_index, $index)
    // {
    //     // dd($id_index);
    //     return $this->groupedTasks[$id_index][$index];
    // }

    public function updateTask($id_index, $sub_index)
    {
        // $empTask = EmpTask::find($id_index);
        // dd(json_decode($empTask->tasks,true)[$index]) ;
        // // = $this->progress_[$taskData['id']];
        // $empTask->save();
    

        $empTask = EmpTask::find($id_index);
        $tasks = json_decode($empTask->tasks, true);
    
        // Update the progress for the specific task
        // dd($tasks,$tasks[$sub_index],$sub_index, $tasks[$sub_index]['progress'] );
        $tasks[$sub_index]['progress'] = $this->progress_[$id_index . '_' . $sub_index];
    
        // Save the changes to the database
        // dd(json_encode($tasks));
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
        $empTask->save();

        $this->initializeFilteredTasks();
    }
    
    public function render()
    {
        
        return view('livewire.emp.mytask-table',[
            'groupedTasks' => $this->groupedTasks,
        ]);
    } // END FUNCTION OF RENDER
}