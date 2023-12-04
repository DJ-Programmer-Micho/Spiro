<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // PAGE VIEW
    public function client(){return view('pages.client.index');} // END FUNCTION (CLIENTS)
    public function service(){return view('pages.service.index');} // END FUNCTION (SERVICE)
    public function branch(){return view('pages.branch.index');} // END FUNCTION (BRANCH)
    public function quotation(){return view('pages.quotation.index');} // END FUNCTION (QUOTATION)
}
