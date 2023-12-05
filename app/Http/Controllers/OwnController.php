<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnController extends Controller
{
    public function dashboardOwn(){
        return view('dashboard.own.dashboard.index');
    } // END FUNCTION (DASHBOARD)

    // CLIENT SECTIONB
    public function addClient(){
        return view('dashboard.own.addClient.index');
    } // END FUNCTION (DASHBOARD)
}
