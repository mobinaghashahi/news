<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHomePage(){
        return view('showNews', ['news' => News::all()]);
    }
}
