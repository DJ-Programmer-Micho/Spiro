<?php

namespace App\Http\Livewire\Own;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Notification;
// use App\Notifications\Dashboard\TelegramBranchNew;
// use App\Notifications\Dashboard\TelegramBranchUpdate;
// use App\Notifications\Dashboard\TelegramBranchDelete;


class DashboardLivewire extends Component
{
    // use WithPagination; 
    // protected $paginationTheme = 'bootstrap';


    public function render()
    {
        return view('livewire.own.dashboard');
    } // END FUNCTION OF RENDER
}