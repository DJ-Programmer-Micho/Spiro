<?php

namespace App\Http\Livewire\Emp;

use App\Models\Branch;
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


    public function render()
    {
        $data = [];
        $colspan = 6;
        $cols_th = ['#','Client Name', 'Invocie ID', 'Description', 'Grand Total ($)', 'Grand Total (IQD)', 'Due ($)', 'Due (IQD)', 'Status','Created Date', 'Actions'];
        $cols_td = ['id','invoice.client.client_name','invoice_id','invoice.description','grand_total_dollar','grand_total_iraqi', 'due_dollar','due_iraqi', 'cash_status','created_at'];

        return view('livewire.emp.mytask-table',[
            'items' => $data ?? [],
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    } // END FUNCTION OF RENDER
}