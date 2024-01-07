<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EdtController extends Controller
{
    public function dashboardedt(){
        return view('dashboard.edt.dashboard.index');
    } // END FUNCTION (DASHBOARD)

    public function client(){
        return view('dashboard.edt.client.index');
    } // END FUNCTION (DASHBOARD)

    public function quotation(){
        return view('dashboard.edt.quotation.index');
    } // END FUNCTION (DASHBOARD)

    public function invoice(){
        return view('dashboard.edt.invoice.index');
    } // END FUNCTION (DASHBOARD)

    public function cash(){
        return view('dashboard.edt.cash.index');
    } // END FUNCTION (DASHBOARD)

    public function myTask(){
        return view('dashboard.edt.mytask.index');
    } // END FUNCTION (DASHBOARD)
}
