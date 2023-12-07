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
}
