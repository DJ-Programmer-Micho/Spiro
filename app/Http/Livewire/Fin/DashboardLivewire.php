<?php

namespace App\Http\Livewire\Fin;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\EmpTask;
use App\Models\Expense;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\Quotation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DashboardLivewire extends Component
{
    public $availableYears;
    public $selectedYear;
    public $selectedMonth = 'all';
    public $chartDataUsrtCount;
    public $chartDataTaskCount;
    public $singleData;

    public $totalExpenseDollar = null;
    public $totalExpenseIraqi = null;
    public $totalProfitDollar = null;
    public $totalProfitIraqi = null;
    public $totalEarningDollar = null;
    public $totalEarningIraqi = null;
    public $totalPayedDollar = null;
    public $totalPayedIraqi = null;
    public $totalDueDollar = null;
    public $totalDueIraqi = null;
    public $totalNetProfitDollar = null;
    public $totalNetProfitiraqi = null;
    public $totalQuotation = null;
    public $totalInvoice = null;
    public $totalCash = null;
    public $totalUser = null;
    public $totalClient = null;

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
            $this->selectedYear = now()->year;
            $this->chartDataUsrtCount = $this->pieUserCount();
            $this->chartDataTaskCount = $this->pieTaskCount();
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
    
    // private function getTotalExpenseLifetimeDollar()
    // {
    //     return Expense::sum('cost_dollar');
    // }
    // private function getTotalExpenseLifetimeIraqi()
    // {
    //     return Expense::sum('cost_iraqi');
    // }
    // private function getTotalEarningLifetimeDollar()
    // {
    //     return Invoice::sum('grand_total_dollar');
    // }
    // private function getTotalEarningLifetimeIraqi()
    // {
    //     return Invoice::sum('grand_total_iraqi');
    // }
    // private function getTotalPayedLifetimeDollar()
    // {
    //     $records = Cash::get();
    //     $sumPaymentAmountIraqi = collect($records)->sum(function ($record) {
    //         $payments = json_decode($record->payments, true);
    //         return collect($payments)->sum('paymentAmountDollar');
    //     });
    
    //     return $sumPaymentAmountIraqi;
    // }
    // private function getTotalPayedLifetimeIraqi()
    // {
    //     $records = Cash::get();
    //     $sumPaymentAmountIraqi = collect($records)->sum(function ($record) {
    //         $payments = json_decode($record->payments, true);
    //         return collect($payments)->sum('paymentAmountIraqi');
    //     });
    
    //     return $sumPaymentAmountIraqi;
    // }

    // PRIVATE FUNCTIONS
    // START TOTAL EXPENSES IN DOLLAR
    private function getTotalExpenseLifetimeDollar() {
        $currentMonth = $this->selectedMonth;
        if ($currentMonth !== 'month' && $currentMonth !== null && $currentMonth !== '' && $currentMonth !== 'all') {
            $query = Expense::where('payed_date', 'like', $currentMonth . '%'); 
        } else {
            $query = Expense::whereYear('payed_date', $this->selectedYear);
        }
        return $query->sum('cost_dollar');
    }
    // END TOTAL EXPENSES IN DOLLAR

    // START TOTAL EXPENSES IN IRAQI
    private function getTotalExpenseLifetimeIraqi() {
        $currentMonth = $this->selectedMonth;
        if ($currentMonth !== 'month' && $currentMonth !== null && $currentMonth !== '' && $currentMonth !== 'all') {
            $query = Expense::where('payed_date', 'like', $currentMonth . '%'); 
        } else {
            $query = Expense::whereYear('payed_date', $this->selectedYear);
        }
        return $query->sum('cost_iraqi');
    }
    // END TOTAL EXPENSES IN IRAQI

    // START TOTAL EARNING IN DOLLAR
    private function getTotalEarningLifetimeDollar() {
        $currentMonth = $this->selectedMonth;
        if ($currentMonth !== 'month' && $currentMonth !== null && $currentMonth !== '' && $currentMonth !== 'all') {
            $query = Invoice::where('invoice_date', 'like', $currentMonth . '%'); 
        } else {
            $query = Invoice::whereYear('invoice_date', $this->selectedYear);
        }
    
        return $query->sum('grand_total_dollar');
    }
    // END TOTAL EARNING IN DOLLAR

    // START TOTAL EARNING IN IRAQI
    private function getTotalEarningLifetimeIraqi() {
        $currentMonth = $this->selectedMonth;
        if ($currentMonth !== 'month' && $currentMonth !== null && $currentMonth !== '' && $currentMonth !== 'all') {
            $query = Invoice::where('invoice_date', 'like', $currentMonth . '%'); 
            // dd(  $query);
        } else {
            $query = Invoice::whereYear('invoice_date', $this->selectedYear);
        }
        return $query->sum('grand_total_iraqi');
    }
    // END TOTAL EARNING IN IRAQI
    
    // START PAID EARNING IN DOLLAR
    private function getTotalPayedLifetimeDollar() {

        $currentMonth = $this->selectedMonth;
        if ($currentMonth !== 'month' && $currentMonth !== null && $currentMonth !== '' && $currentMonth !== 'all') {
            $records = Cash::select('payments')
            ->get()
            ->filter(function ($record) use ($currentMonth) {
                $payments = json_decode($record->payments, true);
                return collect($payments)->pluck('payment_date')->contains(function ($paymentDate) use ($currentMonth) {
                    return Str::startsWith($paymentDate, $currentMonth);
                });
            })
            ->map(function ($record) use ($currentMonth) {
                $payments = json_decode($record->payments, true);
                return [
                    'day_date' => collect($payments)->pluck('payment_date'),
                    'paymentAmountDollar' => collect($payments)->pluck('paymentAmountDollar'),
                    'filteredAmountDollar' => collect($payments)
                        ->filter(function ($payment) use ($currentMonth) {
                            return Str::startsWith($payment['payment_date'], $currentMonth);
                        })
                        ->pluck('paymentAmountDollar'),
                ];
            })
            ->values();
            $sumPaymentAmountDollar = $records->pluck('filteredAmountDollar')->flatten()->sum();
            return $sumPaymentAmountDollar;
        } else {
            $records = Cash::whereYear('cash_date', $this->selectedYear)->get();
            $sumPaymentAmountIraqi = collect($records)->sum(function ($record) {
                $payments = json_decode($record->payments, true);
                return collect($payments)->sum('paymentAmountDollar');
            });
        }

        return $sumPaymentAmountIraqi;
    }
    // END PAID EARNING IN DOLLAR

    // START PAID EARNING IN IRAQI
    private function getTotalPayedLifetimeIraqi() {
        $currentMonth = $this->selectedMonth;
        if ($currentMonth !== 'month' && $currentMonth !== null && $currentMonth !== '' && $currentMonth !== 'all') {
                    $records = Cash::select('payments')
            ->get()
            ->filter(function ($record) use ($currentMonth) {
                $payments = json_decode($record->payments, true);
                return collect($payments)->pluck('payment_date')->contains(function ($paymentDate) use ($currentMonth) {
                    return Str::startsWith($paymentDate, $currentMonth);
                });
            })
            ->map(function ($record) use ($currentMonth) {
                $payments = json_decode($record->payments, true);
                return [
                    'day_date' => collect($payments)->pluck('payment_date'),
                    'paymentAmountIraqi' => collect($payments)->pluck('paymentAmountIraqi'),
                    'filteredAmountDollar' => collect($payments)
                        ->filter(function ($payment) use ($currentMonth) {
                            return Str::startsWith($payment['payment_date'], $currentMonth);
                        })
                        ->pluck('paymentAmountIraqi'),
                ];
            })
            ->values();
            $sumPaymentAmountDollar = $records->pluck('filteredAmountDollar')->flatten()->sum();
            return $sumPaymentAmountDollar;
        } else {
            $records = Cash::whereYear('cash_date', $this->selectedYear)->get();
            $sumPaymentAmountIraqi = collect($records)->sum(function ($record) {
                $payments = json_decode($record->payments, true);
                return collect($payments)->sum('paymentAmountIraqi');
            });
        }

        return $sumPaymentAmountIraqi;

        // $records = Cash::get();
        // $sumPaymentAmountIraqi = collect($records)->sum(function ($record) {
        //     $payments = json_decode($record->payments, true);
        //     return collect($payments)->sum('paymentAmountIraqi');
        // });
    
        // return $sumPaymentAmountIraqi;
    }
    // END PAID EARNING IN IRAQI

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

    public function updatedselectedMonth()
    {
        $this->getTotalEarningLifetimeDollar();
        $this->getTotalExpenseLifetimeIraqi();
        $this->getTotalPayedLifetimeDollar();
        $this->getTotalPayedLifetimeIraqi();
        $this->getTotalEarningLifetimeDollar();
        $this->getTotalEarningLifetimeIraqi();
        $this->getTotalPayedLifetimeDollar();
        $this->getTotalPayedLifetimeIraqi();
        $this->getTotalEarningLifetimeDollar();
        $this->getTotalEarningLifetimeIraqi();
    }


    public function render()
    {
        if (Auth::check()) {
            $this->totalExpenseDollar = $this->getTotalExpenseLifetimeDollar();
            $this->totalExpenseIraqi = $this->getTotalExpenseLifetimeIraqi();
            $this->totalEarningDollar = $this->getTotalPayedLifetimeDollar()  - $this->totalExpenseDollar;
            $this->totalEarningIraqi = $this->getTotalPayedLifetimeIraqi() - $this->totalExpenseIraqi;
            $this->totalProfitDollar = $this->getTotalEarningLifetimeDollar();
            $this->totalProfitIraqi = $this->getTotalEarningLifetimeIraqi() ;
            $this->totalPayedDollar = $this->getTotalPayedLifetimeDollar();
            $this->totalPayedIraqi = $this->getTotalPayedLifetimeIraqi();
            $this->totalDueDollar = $this->getTotalEarningLifetimeDollar() - $this->totalPayedDollar;
            $this->totalDueIraqi = $this->getTotalEarningLifetimeIraqi() - $this->totalPayedIraqi;
            $this->totalNetProfitDollar = $this->totalProfitDollar - $this->totalExpenseDollar;
            $this->totalNetProfitiraqi = $this->totalProfitIraqi - $this->totalExpenseIraqi;

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

        return view('livewire.fin.dashboard',[
            'events' => $events
        ]);
    } // END FUNCTION OF RENDER
}
