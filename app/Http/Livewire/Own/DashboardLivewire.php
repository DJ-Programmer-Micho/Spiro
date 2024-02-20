<?php

namespace App\Http\Livewire\Own;

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
use App\Exports\CashExport;
use Illuminate\Support\Str;
use App\Exports\ExpenseExport;
use App\Exports\ContractExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DashboardLivewire extends Component
{
    public $availableYears;
    public $selectedYear;
    public $selectedMonth = 'all';
    public $chartDataUsrtCount;
    public $chartDataTaskCount;
    public $singleData;

    public $summaryTable = null; //NEW
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
            $this->selectedYear = now()->year; // Initialize with the current year
            $this->chartDataUsrtCount = $this->pieUserCount();
            $this->summaryTable = $this->summary();
            $this->chartDataTaskCount = $this->pieTaskCount();
            $this->loadChartData($this->selectedYear);
        }
    }

    private function summary(){
        return Invoice::orderBy('created_at', 'DESC')->take(5)->get();
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



    //////////////////
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


    public $chartData;
    public $selectedGranularity = 'day';

    private function loadChartData($selectedYear)
    {

        // dd('asd');
        $formattedData = [];
    
        foreach (['contract', 'profit', 'expense'] as $dataType) {
            $data = $this->fetchChartData($dataType, $selectedYear);
    
            // Initialize an array to store data for each day in each month
            $daysInMonth = [];
            for ($month = 1; $month <= 12; $month++) {
                $yearMonth = sprintf('%04d-%02d', $selectedYear, $month);
                $daysInMonth[$yearMonth] = array_fill(1, cal_days_in_month(CAL_GREGORIAN, $month, $selectedYear), 0);
            }
    
            // Process the data and fill in the counts for each day
            $dailyCountsByMonth = $daysInMonth;
            if ($dataType === 'profit') {
                foreach ($data as $item) {
                    $yearMonth = substr($item['day_date'], 0, 7);
                    $day = intval(substr($item['day_date'], -2));
                    $count = floatval($item['count']);

                    // $dailyCountsByMonth[$yearMonth][$day] = $item['count'];
                    if (isset($dailyCountsByMonth[$yearMonth][$day])) {
                        // If it exists, add the count to the existing entry
                        $dailyCountsByMonth[$yearMonth][$day] += $count;
                    } else {
                        // If it doesn't exist, create a new entry
                        $dailyCountsByMonth[$yearMonth][$day] = $count;
                    }
                }
            } else {
                foreach ($data as $item) {
                    $yearMonth = substr($item['day_date'], 0, 7);
                    $day = intval(substr($item['day_date'], -2));
                    $dailyCountsByMonth[$yearMonth][$day] = $item['count'];
                }
            }
           
    
            $formattedData[] = [
                'label' => $dataType,
                'data' => $dailyCountsByMonth,
            ];
        }
    
        $this->chartData = $formattedData;
        // dd($this->chartData);
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
        $this->dispatchBrowserEvent('chartDataUpdated',  $this->chartData);  
    }

    private function fetchChartData($dataType, $selectedYear)
    {
        $currency = 'dollar';
        $amountColumnInvoice = ($currency === 'dollar') ? 'grand_total_dollar' : 'grand_total_iraqi';
        $amountColumnDue = ($currency === 'dollar') ? 'due_dollar' : 'due_iraqi';
        $amountColumnExpense = ($currency === 'dollar') ? 'cost_dollar' : 'cost_iraqi';

        switch ($dataType) {
            case 'contract':
                return Invoice::selectRaw('DATE_FORMAT(invoice_date, "%Y-%m-%d") as day_date, DAY(invoice_date) as day, sum('.$amountColumnInvoice.') as count')
                    // ->where('business_name', $businessName)
                    ->whereYear('invoice_date', $selectedYear)
                    ->groupBy('day_date', 'day')
                    ->orderBy('day_date', 'asc')
                    ->get();
                   
            case 'profit':
                $result = Cash::selectRaw('
                JSON_UNQUOTE(JSON_EXTRACT(payments, "$[*].payment_date")) as day_date,
                JSON_EXTRACT(payments, "$[*].paymentAmountDollar") as paymentAmountDollar
            ')
            ->get();
            $transformedResults = collect();
            
            foreach ($result as $record) {
                // Decode the JSON strings to arrays
                $dayDates = json_decode($record->day_date, true);
                $paymentAmounts = json_decode($record->paymentAmountDollar, true);
            
                // Ensure both arrays are not empty
                if (empty($dayDates) || empty($paymentAmounts)) {
                    continue; // Skip the current record if data is empty
                }
            
                // Iterate over each payment and sum the amounts
                foreach ($dayDates as $index => $date) {
                    if(date('Y', strtotime($date)) ==  $selectedYear) {
                                 // Sum the paymentAmounts
                        $sumPaymentAmount = floatval($paymentAmounts[$index]);
            
                        // Extract day information
                        $day = date('d', strtotime($date));
                
                        // Add the transformed data to the collection
                        $transformedResults->push([
                            'day_date' => $date,
                            'day' => $day,
                            'count' => $sumPaymentAmount,
                        ]);
                    }
           
                   
                }
            }
            
            // Dump the transformed results
            // dd($transformedResults);
            return $transformedResults;

            case 'expense':
                return Expense::selectRaw('DATE_FORMAT(payed_date, "%Y-%m-%d") as day_date, DAY(payed_date) as day, sum('.$amountColumnExpense.') as count')
                    // ->where('business_name_id', $businessName)
                    ->whereYear('payed_date', $selectedYear)
                    // ->whereNotNull('food_id')
                    ->groupBy('day_date', 'day')
                    ->orderBy('day_date', 'asc')
                    ->get();

            default:
                return collect();
        }
    }
    public function updatedSelectedYear()
    {
        $this->loadChartData($this->selectedYear, auth()->user()->name);
        $this->dispatchBrowserEvent('chartDataUpdated',  $this->chartData);
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


        return view('livewire.own.dashboard',[
            'events' => $events,
            'groupedTasksByUser' => $groupedTasksByUser
        ]);
    } // END FUNCTION OF RENDER

    //EXCEL FORM GET VALUES
    public $getInvoiceIds = [];
    public $getClientNames = [];
    // public $getCompanyNames = [];
    // public $companyName = null;
    public $option = null;
    public $startDate;
    public $endDate;
    public $clientName = null;
    public $invoiceId = 'none';
    public $cashId = 'none';

    public function prepareExpenseReport(){
        //do nothing
        return;
    }

    // START CONTRACT EXPORT
    public function contractExport(){
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $cashId = $this->cashId;
        $companyName = $this->companyName ?? '';
        $option = $this->option;
        $clientName = $this->clientName;
        // dd($startDate, $endDate, $invoiceId, $companyName, $option, $clientName);
        return Excel::download(new ContractExport($startDate, $endDate, $cashId, $companyName, $option, $clientName), 'contractReport_'.now()->format('Y-m-d').'_.xlsx');
    }
    // END CONTRACT EXPORT

    // START CONTRACT EXPORT
    public function cashExport(){
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $invoiceId = $this->invoiceId;
        $companyName = $this->companyName ?? '';
        $option = $this->option;
        $clientName = $this->clientName;
        // dd($startDate, $endDate, $invoiceId, $companyName, $option, $clientName);
        return Excel::download(new CashExport($startDate, $endDate, $invoiceId, $companyName, $option, $clientName), 'cashReport_'.now()->format('Y-m-d').'_.xlsx');
    }
    // END CONTRACT EXPORT

    public function expenseExport(){
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $option = $this->option;
        return Excel::download(new ExpenseExport($startDate, $endDate, $option), 'expenseReport_'.now()->format('Y-m-d').'_.xlsx');
    }

    public function prepareCashesReport(){
        $this->prepareCashesIdReport();
        $this->prepareClientReport();
        // $this->prepareComapnyReport();
    }

    public $getCashIds;
    private function prepareCashesIdReport(){
        $cashes = Cash::all();
        if ($cashes->count() > 0) {
            $this->getCashIds = $cashes->pluck('id');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('No invoices IDs found.')]);
        }
    }

    
    // START SELECTED CASH ID PREPARE CONTRACT REPORT
    public function prepareSelectedCashId(){
        if ($this->cashId != 'none') {
            $cash = Cash::with('invoice.client')->where('id', $this->cashId)->first();
            // $cash = Cash::with('invoice.client.company')->where('id', $this->cashId)->first(); OLD
            // dd($cash);
            if ($cash) {
                $this->getClientNames = [$cash->invoice->client->toArray()];
                // $this->getCompanyNames = [$cash->invoice->client->company->toArray()];
                if ($this->getClientNames && !empty($this->getClientNames)) {
                    $this->clientName = $this->getClientNames[0]['id'];
                    // $this->companyName = $this->getClientNames[0]['company_id'];
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('No client found for the selected invoice.')]);
                }
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('No invoice found with the selected ID.')]);
            }
        } else {
            $this->prepareClientReport();
            // $this->prepareComapnyReport();
            // $this->prepareComapnyReport();
            $this->clientName = '';
            // $this->companyName = '';
        }
    }
    // END SELECTED CASH ID PREPARE CONTRACT REPORT

    // START SELECTED CLIENT ID PREPARE CONTRACT REPORT
    public function prepareSelectedCashClientName()
    {
        if ($this->cashId == 'none') {
            // User selected client first, load all invoices for this client
            if ($this->clientName != 'none') {
                $client = Client::with('invoice.cashes')->find($this->clientName);
                // $client = Client::with('company','invoice.cashes')->find($this->clientName); OLD
                if ($client) {

                    $this->getCashIds = $client->invoice->flatMap(function ($invoice) {
                        // dd($invoice->cashes->pluck('id')->toArray());
                        return $invoice->cashes->pluck('id')->toArray();
                    })->toArray();
                    // if($client->company == null) {
                    //     $this->getCompanyNames = [];
                    // } else {
                    //     $this->getCompanyNames = [$client->company->toArray()];
                    // }
                    // $this->companyName = $this->getCompanyNames[0]['id'] ?? 'none';
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('No client found for the selected ID.')]);
                }
            } else {
                $this->prepareClientReport();
                $this->prepareCashesIdReport();
                // $this->prepareComapnyReport();
                $this->invoiceId = 'none';
                // $this->companyName = 'none';
            }
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('Please Clean Up.')]);
        }
    }
    // END SELECTED CLIENT ID PREPARE CONTRACT REPORT

    // START SELECTED COMPANY ID PREPARE CASH REPORT
    // public function prepareSelectedCashCompanyName()
    // {
    //     if ($this->invoiceId == 'none') {
    //         // User selected client first, load all invoices for this client
    //         if ($this->companyName != 'none') {
    //             $company = Company::with('clients.invoice.cashes')->find($this->companyName);

    //             if ($company) {
    //                 $this->getCashIds = $company->clients->flatMap(function ($client) {
    //                     return $client->invoice->flatMap(function ($invoice) {
    //                         return $invoice->cashes->pluck('id')->toArray();
    //                     });
    //                 })->toArray();

    //             } else {
    //                 $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('No company found for the selected ID.')]);
    //             }
    //         } else {
    //             $this->prepareClientReport();
    //             $this->prepareCashesIdReport();
    //             // $this->prepareComapnyReport();
    //             $this->invoiceId = 'none';
    //             $this->clientName = 'none';
    //         }
    //     } else {
    //         $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('Please Clean Up.')]);
    //     }
    // }
    // END SELECTED COMPANY ID PREPARE CASH REPORT

    public function prepareContractReport(){
        $this->prepareInvoiceIdsReport();
        $this->prepareClientReport();
        // $this->prepareComapnyReport();
    }

    // START PREPARE CONTRACT REPORT
    private function prepareInvoiceIdsReport(){
        $invoices = Invoice::all();
        if ($invoices->count() > 0) {
            $this->getInvoiceIds = $invoices->pluck('id');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('No invoices IDs found.')]);
        }
    }
    // END PREPARE CONTRACT REPORT

    // START SELECTED INVOICE ID PREPARE CONTRACT REPORT
    // private function prepareComapnyReport(){
    //     $companies = Company::all();
    //     if ($companies->count() > 0) {
    //         $this->getCompanyNames = $companies;
    //     } else {
    //         $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('No invoices IDs found.')]);
    //     }
    // }
    // START SELECTED INVOICE ID PREPARE CONTRACT REPORT

    // START SELECTED INVOICE ID PREPARE CONTRACT REPORT
    private function prepareClientReport(){
        $clients = Client::orderBy('client_name', 'ASC')->get();
        if ($clients->count() > 0) {
            $this->getClientNames = $clients;
            // dd($this->getClientNames);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('No invoices IDs found.')]);
        }
    }
    // START SELECTED INVOICE ID PREPARE CONTRACT REPORT

    // START SELECTED INVOICE ID PREPARE CONTRACT REPORT
    public function prepareSelectedInvoiceId(){
        if ($this->invoiceId != 'none') {
            $invoice = Invoice::with('client')->where('id', $this->invoiceId)->first();
            if ($invoice) {
                $this->getClientNames = [$invoice->client->toArray()];
                // $this->getCompanyNames = [$invoice->client->company->toArray()];
                if ($this->getClientNames && !empty($this->getClientNames)) {
                    $this->clientName = $this->getClientNames[0]['id'];
                    // $this->companyName = $this->getClientNames[0]['company_id'];
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('No client found for the selected invoice.')]);
                }
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('No invoice found with the selected ID.')]);
            }
        } else {
            $this->prepareClientReport();
            // $this->prepareComapnyReport();
            // $this->prepareComapnyReport();
            $this->clientName = '';
            // $this->companyName = '';
        }
    }
    // END SELECTED INVOICE ID PREPARE CONTRACT REPORT

    // START SELECTED CLIENT ID PREPARE CONTRACT REPORT
    public function prepareSelectedClientName()
    {
        if ($this->invoiceId == 'none') {
            // User selected client first, load all invoices for this client
            if ($this->clientName != 'none') {
                $client = Client::find($this->clientName);
                // $client = Client::with('company')->find($this->clientName); OLD
                if ($client) {
                    $this->getInvoiceIds = $client->invoice->pluck('id');
                    // if($client->company == null) {
                    //     $this->getCompanyNames = [];
                    // } else {
                    //     $this->getCompanyNames = [$client->company->toArray()];
                    // }
                    // $this->companyName = $this->getCompanyNames[0]['id'] ?? 'none';
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('No client found for the selected ID.')]);
                }
            } else {
                $this->prepareClientReport();
                $this->prepareInvoiceIdsReport();
                // $this->prepareComapnyReport();
                $this->invoiceId = 'none';
                // $this->companyName = 'none';
            }
        } else {
            // $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('Please Clean Up.')]);
        }
    }
    // END SELECTED CLIENT ID PREPARE CONTRACT REPORT

    // public function prepareSelectedCompanyName()
    // {
    //     if ($this->invoiceId == 'none') {
    //         // User selected client first, load all invoices for this client
    //         if ($this->companyName != 'none') {
    //             $company = Company::with('clients.invoice')->find($this->companyName);

    //             if ($company) {
    //                 $this->getInvoiceIds = $company->clients->flatMap(function ($client) {
    //                     // dd();
    //                     return $client->invoice->pluck('id')->toArray();
    //                 })->toArray();

    //                 $this->getClientNames = $company->clients->toArray();
    //             } else {
    //                 $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('No company found for the selected ID.')]);
    //             }
    //         } else {
    //             $this->prepareClientReport();
    //             $this->prepareInvoiceIdsReport();
    //             $this->prepareComapnyReport();
    //             $this->invoiceId = 'none';
    //             $this->clientName = 'none';
    //         }
    //     } else {
    //         $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('Please Clean Up.')]);
    //     }
    // }
    // END SELECTED COMPANY ID PREPARE CONTRACT REPORT

    public function closeModal() {
        $this->resetModal();
    } // END FUNCTION OF CLOSE MODAL

    
    private function resetModal(){
        $this->invoiceId = 'none';
        $this->cashId = 'none';
        $this->startDate = null;
        $this->endDate = null;
        // $this->companyName = null;
        $this->option = null;
        $this->clientName = null;
    } // END FUNCTION OF RESET VARIABLES

}


