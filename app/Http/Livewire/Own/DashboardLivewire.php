<?php

namespace App\Http\Livewire\Own;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Branch;
use App\Models\Invoice;
use Livewire\Component;
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

    protected $listeners = [
        'quickView' => 'quickView',
    ];


    public $singleData;
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


    public $totalEarningDollar = null;
    public $totalEarningIraqi = null;
    public $totalPayedDollar = null;
    public $totalPayedIraqi = null;
    public $totalDueDollar = null;
    public $totalDueIraqi = null;

    public function render()
    {
        if (Auth::check()) {
            $this->totalEarningDollar = $this->getTotalEarningLifetimeDollar();
            $this->totalEarningIraqi = $this->getTotalEarningLifetimeIraqi();
            $this->totalPayedDollar = $this->getTotalPayedLifetimeDollar();
            $this->totalPayedIraqi = $this->getTotalPayedLifetimeIraqi();
            $this->totalDueDollar = $this->totalEarningDollar - $this->totalPayedDollar;
            $this->totalDueIraqi = $this->totalEarningIraqi - $this->totalPayedIraqi;
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

        return view('livewire.own.dashboard',[
            'events' => $events
        ]);
    } // END FUNCTION OF RENDER
}
