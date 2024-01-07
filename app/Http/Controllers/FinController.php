<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinController extends Controller
{
    public function dashboardfin(){
        return view('dashboard.fin.dashboard.index');
    } // END FUNCTION (DASHBOARD)

    public function user(){
        return view('dashboard.fin.user.index');
    } // END FUNCTION (DASHBOARD)

    public function client(){
        return view('dashboard.fin.client.index');
    } // END FUNCTION (DASHBOARD)

    public function service(){
        return view('dashboard.fin.service.index');
    } // END FUNCTION (DASHBOARD)

    public function payment(){
        return view('dashboard.fin.payment.index');
    } // END FUNCTION (DASHBOARD)

    public function expense(){
        return view('dashboard.fin.expense.index');
    } // END FUNCTION (DASHBOARD)

    public function expenseBill(){
        return view('dashboard.fin.expenseBill.index');
    } // END FUNCTION (DASHBOARD)

    public function quotation(){
        return view('dashboard.fin.quotation.index');
    } // END FUNCTION (DASHBOARD)

    public function invoice(){
        return view('dashboard.fin.invoice.index');
    } // END FUNCTION (DASHBOARD)

    public function cash(){
        return view('dashboard.fin.cash.index');
    } // END FUNCTION (DASHBOARD)

    public function myTask(){
        return view('dashboard.fin.mytask.index');
    } // END FUNCTION (DASHBOARD)
}