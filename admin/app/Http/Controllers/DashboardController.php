<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //dashboard
    public function dashboard(){
        return view('page.dashboard');
    }
}
