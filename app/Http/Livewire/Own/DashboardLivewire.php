<?php

namespace App\Http\Livewire\Own;

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
            $this->chartDataUsrtCount = $this->pieUserCount();
            $this->chartDataTaskCount = $this->pieTaskCount();
            // $this->loadChartData($this->selectedYear, auth()->user()->name);

            // dd(auth()->user()->profile);
            // $this->profile['avatar'] = app('cloudfront') . (auth()->user()->settings->background_img_avatar ?? 'mine-setting/user.png');
            // $this->profile['restName'] = auth()->user()->name;
            // $this->profile['name'] = auth()->user()->profile->fullname;
            // $this->profile['email'] = auth()->user()->email;
            // $this->profile['phone'] = auth()->user()->profile->phone;
            // $this->profile['country'] = auth()->user()->profile->country;
            // $this->profile['create'] = auth()->user()->subscription->start_at;
            // $this->profile['expire'] = auth()->user()->subscription->expire_at;
            // $this->profile['plan_id'] = auth()->user()->subscription->plan_id;
            // $plan_name = Plan::where('id',  auth()->user()->subscription->plan_id)
            // ->first();

            // $this->profile['plan_name'] = $plan_name->name[$this->glang];
        }
    }

    private function pieUserCount() {

        $tasksData = EmpTask::all();

        // Step 2: Parse the JSON data from the tasks column
        $allTasks = [];
        foreach ($tasksData as $taskEntry) {
            $tasks = json_decode($taskEntry->tasks, true);
            foreach ($tasks as $task) {
                $user = User::find($task['name']); // Fetch the user by ID
                $allTasks[] = [
                    'name' => $user ? $user->name : 'Unknown User', // Use the user's name or a default value
                    'task' => $task['task'],
                    // Add other relevant data here
                ];
            }
        }

        // Step 3: Count occurrences of each name
        $nameCounts = array_count_values(array_column($allTasks, 'name'));

        // Step 4: Select the top 5 users
        arsort($nameCounts); // Sort in descending order
        $topUsers = array_slice($nameCounts, 0, 5, true);

        // Step 5: Prepare data for Chart.js
        return [
            'labels' => array_keys($topUsers),
            'datasets' => [
                [
                    'data' => array_values($topUsers),
                    // 'color' => '#ffffff',
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                    ],
                ],
            ],
        ];
    }

    private function pieTaskCount() {
        $tasksData = EmpTask::all();
    
        // Step 2: Parse the JSON data from the tasks column
        $allTasks = [];
        foreach ($tasksData as $taskEntry) {
            $tasks = json_decode($taskEntry->tasks, true);
            foreach ($tasks as $task) {
                $task = Task::find($task['task']);
                $allTasks[] = [
                    'taskCount' => $task->task_option ? $task->task_option : 'Unknown User' , // Assuming 'task' holds the count of tasks
                    // Add other relevant data here
                ];
            }
        }
    
        // Step 3: Count occurrences of each task count
        $taskCounts = array_count_values(array_column($allTasks, 'taskCount'));
    
        // Step 4: Prepare data for Chart.js
        return [
            'labels' => array_keys($taskCounts),
            'datasets' => [
                [
                    'data' => array_values($taskCounts),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                    ],
                ],
            ],
        ];
    }
    
    private function getTotalExpenseLifetimeDollar()
    {
        return Expense::sum('cost_dollar');
    }
    private function getTotalExpenseLifetimeIraqi()
    {
        return Expense::sum('cost_iraqi');
    }
    private function getTotalEarningLifetimeDollar()
    {
        return Invoice::sum('grand_total_dollar');
    }
    private function getTotalEarningLifetimeIraqi()
    {
        return Invoice::sum('grand_total_iraqi');
    }
    private function getTotalPayedLifetimeDollar()
    {
        $records = Cash::get();
        $sumPaymentAmountIraqi = collect($records)->sum(function ($record) {
            $payments = json_decode($record->payments, true);
            return collect($payments)->sum('paymentAmountDollar');
        });
    
        return $sumPaymentAmountIraqi;
    }
    private function getTotalPayedLifetimeIraqi()
    {
        $records = Cash::get();
        $sumPaymentAmountIraqi = collect($records)->sum(function ($record) {
            $payments = json_decode($record->payments, true);
            return collect($payments)->sum('paymentAmountIraqi');
        });
    
        return $sumPaymentAmountIraqi;
    }

    private function getTotalQuotation()
    {
        return Quotation::count();
    }
    private function getTotalInvoice()
    {
        return Invoice::count();
    }
    private function getTotalCr()
    {
        return Cash::count();
    }
    private function getTotalClient()
    {
        return Client::count();
    }
    private function getTotalUser()
    {
        return User::count();
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


    public $totalExpenseDollar = null;
    public $totalExpenseIraqi = null;
    public $totalEarningDollar = null;
    public $totalEarningIraqi = null;
    public $totalPayedDollar = null;
    public $totalPayedIraqi = null;
    public $totalDueDollar = null;
    public $totalDueIraqi = null;

    public $totalQuotation = null;
    public $totalInvoice = null;
    public $totalCash = null;

    public $totalUser = null;
    public $totalClient = null;

    public function render()
    {
        if (Auth::check()) {
            $this->totalExpenseDollar = $this->getTotalExpenseLifetimeDollar();
            $this->totalExpenseIraqi = $this->getTotalExpenseLifetimeIraqi();
            $this->totalEarningDollar = $this->getTotalEarningLifetimeDollar();
            $this->totalEarningIraqi = $this->getTotalEarningLifetimeIraqi();
            $this->totalPayedDollar = $this->getTotalPayedLifetimeDollar();
            $this->totalPayedIraqi = $this->getTotalPayedLifetimeIraqi();
            $this->totalDueDollar = $this->totalEarningDollar - $this->totalPayedDollar;
            $this->totalDueIraqi = $this->totalEarningIraqi - $this->totalPayedIraqi;

            $this->totalQuotation = $this->getTotalQuotation();
            $this->totalInvoice = $this->getTotalInvoice();
            $this->totalCash = $this->getTotalCr();

            $this->totalUser = $this->getTotalUser();
            $this->totalClient = $this->getTotalClient();
        }

        $events = [];
        // dd(Invoice::get());
        $data = Invoice::get();
        foreach ($data as $event) {
            $servicesData = json_decode($event->services, true);
            foreach ($servicesData as $serviceEntry) {
                $color = Carbon::parse($serviceEntry['actionDate'])->isBefore(now()) ? '#cc0022' : '#3788d8';
                // Add each service as a separate event
                $events[] = [
                    'id' => $event->id,
                    'title' => $event->description .' | '. $serviceEntry['description'],
                    'start' => Carbon::parse($serviceEntry['actionDate'])->toDateString(),
                    'color' => $color,
                    'information' => [
                        "clientName" =>  $event->client->client_name,
                        "invoiceCreated" =>  $event->invoice_date,
                        "totalCostDollar" =>  $event->grand_total_dollar,
                        "totalCostIraqi" =>  $event->grand_total_iraqi,
                        "services" =>  json_decode($event->services, true)
                    ] 
                    // You can add other service-related information here if needed
                ];
            }
        }

        /////////////////////////////
        $groupedTasksByUser = [];

        foreach (User::where('role', '!=', '1')->get() as $user) {
            $userId =  $user->id;
            $groupedTasks = EmpTask::where('approved', 0)->get()
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
        
            $groupedTasksByUser[$userId] = $groupedTasks;
        }
        
        // dd($groupedTasksByUser);
        
               // Initialize progress array
            //    $this->progress_ = [];
            //    foreach ($this->groupedTasks as $id_index => $group) {
            //        $taskData = EmpTask::find($id_index);
            //        foreach ($group as $index => $subgroup) {
            //            foreach ($subgroup as $sub_index => $sub_task) {
            //            $this->progress_[$id_index . '_' . $sub_index] = $sub_task['progress'] ?? 0;
            //        }
            //        }
            //    }
            
            



        /////////////////////////////

        return view('livewire.own.dashboard',[
            'events' => $events,
            'groupedTasksByUser' => $groupedTasksByUser
        ]);
    } // END FUNCTION OF RENDER
}
