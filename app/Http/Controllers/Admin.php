<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Admin extends Controller
{
    public function showDashboard(){
        return view('admin.dashboard', [
            'visitedMonthAgo' => visitedMonthAgo(),
        ]);
    }
    public function addNews(){
        return view('admin.addNews');
    }
}
