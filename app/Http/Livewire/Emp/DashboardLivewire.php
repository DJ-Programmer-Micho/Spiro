<?php

namespace App\Http\Livewire\Emp;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Task;
use App\Models\User;
use App\Models\Branch;
use App\Models\Client;
use App\Models\EmpTask;
use App\Models\Expense;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\Quotation;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
// use App\Notifications\Dashboard\TelegramBranchNew;
// use App\Notifications\Dashboard\TelegramBranchUpdate;
// use App\Notifications\Dashboard\TelegramBranchDelete;

class DashboardLivewire extends Component
{
    // use WithPagination; 
    // protected $paginationTheme = 'bootstrap';


    public $availableYears;
    public $selectedYear;
    public $chartDataUsrtCount;
    public $chartDataTaskCount;
    public $singleData;

    protected $listeners = [
        'quickView' => 'quickView',
    ];


    public function quickView($id)
    {
        $this->singleData = [];
        $this->singleData = Invoice::where('id', $id)->first();
        $this->singleData = [
            "clientName" =>  $this->singleData->client->client_name,
            "invoiceCreated" =>  $this->singleData->invoice_date,
            "totalCostDollar" =>  $this->singleData->grand_total_dollar,
            "totalCostIraqi" =>  $this->singleData->grand_total_iraqi,
            "services" =>  $this->singleData->services
        ];

        $this->dispatchBrowserEvent('openQuickViewModal');
        // dd($this->singleData);
    }
    public function mount()
    {
        // $this->glang = app('glang');
        // $this->filteredLocales = app('userlanguage');

        if (Auth::check()) {
            $this->availableYears = $this->getAvailableYears();
            $this->selectedYear = now()->year; // Initialize with the current year
        }
    }

    private function countUserTasksTotal()
    {
        // Retrieve EmpTask records for the given user
        $userId = auth()->user()->id;
        $empTasks = EmpTask::whereJsonContains('tasks', [['name' => (string) $userId ]])
            ->get();
            // Count the total number of tasks
            $totalTasks = $empTasks->flatMap(function ($empTask) {
                return json_decode($empTask->tasks, true);
            })->filter(function ($task) use ($userId) {
                return $task['name'] == $userId; // Change this condition to the desired name
            })->count();

        return $totalTasks;
    }

    private function countUserTasksInProceses()
    {
        // Retrieve EmpTask records for the given user
        $userId = auth()->user()->id;
        $empTasks = EmpTask::where('approved', 0)
        ->whereJsonContains('tasks', [['name' => (string) $userId]])
            ->get();

        // Count the total number of tasks
        $totalTasks = $empTasks->flatMap(function ($empTask) {
            return json_decode($empTask->tasks, true);
        })->filter(function ($task) use ($userId) {
            return $task['name'] == $userId; // Change this condition to the desired name
        })->count();

        return $totalTasks;
    }

    private function countUserTasksComplete()
    {
        // Retrieve EmpTask records for the given user
        {
            // Retrieve EmpTask records for the current user
            $userId = auth()->user()->id;
            $empTasks = EmpTask::where('approved', 0)
                ->whereJsonContains('tasks', [['name' => (string) $userId]])
                ->get();
    
     
            $totalTasks = $empTasks->flatMap(function ($empTask) {
                return json_decode($empTask->tasks, true);
            })
            ->filter(function ($task) use ($userId) {
                return $task['name'] == $userId && isset($task['progress']) && $task['progress'] == 100;
            })->count();
    
            return $totalTasks;
        }
    }

    private function countUserTasksLeft()
    {
        // Retrieve EmpTask records for the given user
        {
            // Retrieve EmpTask records for the current user
            $userId = auth()->user()->id;
            $empTasks = EmpTask::where('approved', 0)
                ->whereJsonContains('tasks', [['name' => (string) $userId]])
                ->get();
    
            // Count the total number of tasks with progress not equal to 100
            $totalTasks = $empTasks->flatMap(function ($empTask) {
                return json_decode($empTask->tasks, true);
            })->filter(function ($task) use ($userId) {
                return $task['name'] == $userId && isset($task['progress']) && $task['progress'] <= 99;
            })->count();
    
            return $totalTasks;
        }
    }
   
    private function getAvailableYears()
    {
        // Fetch unique years from the Tracker table
        return Invoice::distinct()
            ->pluck('created_at')
            ->map(function ($date) {
                return date('Y', strtotime($date));
            })
            ->unique()
            ->toArray();
    }


    public $taskTotal = null;
    public $taskComplete = null;
    public $taskLeft = null;
    public $taskProcess = null;

    public function render()
    {
        if (Auth::check()) {
            $this->taskTotal = $this->countUserTasksTotal();
            $this->taskProcess = $this->countUserTasksInProceses();
            $this->taskComplete = $this->countUserTasksComplete();
            $this->taskLeft = $this->countUserTasksLeft();
        }

        $events = [];
        $data = EmpTask::get();
        // dd($data);
        $currentUserId = auth()->user()->id;
        
        foreach ($data as $event) {
            $taskData = json_decode($event->tasks, true);
        
            foreach ($taskData as $taskEntry) {
                // Check if the task is associated with the current user
                if ($taskEntry['name'] == $currentUserId) {
                    // $color = Carbon::parse($taskEntry['start_date'])->isBefore(now()) ? '#cc0022' : ($event->approved == 1 ? '#1cc88a' : '#3788d8');
                    $color = $event->approved == 1 ? '#1cc88a' : (Carbon::parse($taskEntry['start_date'])->isBefore(now()) ? '#cc0022' :  '#3788d8');

        
                    $events[] = [
                        'id' => $event->id,
                        'title' => '#INV -' . $event->invoice->id .' | '. $event->invoice->description,
                        'start' => Carbon::parse($taskEntry['start_date'])->toDateString(),
                        'end' => Carbon::parse($taskEntry['end_date'])->toDateString(),
                        'color' => $color,
                    ];
                }
            }
        }


        return view('livewire.emp.dashboard',[
            'events' => $events,
        ]);
    } // END FUNCTION OF RENDER
}
