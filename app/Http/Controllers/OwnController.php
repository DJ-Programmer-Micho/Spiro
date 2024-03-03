<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnController extends Controller
{
    public function dashboardOwn(){
        return view('dashboard.own.dashboard.index');
    } // END FUNCTION (DASHBOARD)

    public function user(){
        return view('dashboard.own.user.index');
    } // END FUNCTION (DASHBOARD)

    public function client(){
        return view('dashboard.own.client.index');
    } // END FUNCTION (DASHBOARD)

    public function service(){
        return view('dashboard.own.service.index');
    } // END FUNCTION (DASHBOARD)

    public function payment(){
        return view('dashboard.own.payment.index');
    } // END FUNCTION (DASHBOARD)

    public function expense(){
        return view('dashboard.own.expense.index');
    } // END FUNCTION (DASHBOARD)

    public function expenseBill(){
        return view('dashboard.own.expenseBill.index');
    } // END FUNCTION (DASHBOARD)

    public function quotation(){
        return view('dashboard.own.quotation.index');
    } // END FUNCTION (DASHBOARD)

    public function invoice(){
        return view('dashboard.own.invoice.index');
    } // END FUNCTION (DASHBOARD)

    public function cash(){
        return view('dashboard.own.cash.index');
    } // END FUNCTION (DASHBOARD)

    public function createTask(){
        return view('dashboard.own.empTask.index');
    } // END FUNCTION (DASHBOARD)

    public function addTask(){
        return view('dashboard.own.task.index');
    } // END FUNCTION (DASHBOARD)

    public function attend(){
        return view('dashboard.own.attendance.index');
    } // END FUNCTION (DASHBOARD)
}