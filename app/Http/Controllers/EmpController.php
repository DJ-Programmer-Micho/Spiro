<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpController extends Controller
{
    public function dashboardEmp(){
        return view('dashboard.emp.dashboard.index');
    } // END FUNCTION (DASHBOARD)

    public function myTask(){
        return view('dashboard.emp.mytask.index');
    } // END FUNCTION (MY TASK)
}