<?php

namespace App\Http\Controllers;

use App\Models\Details;
use App\Models\Instrument;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHomePage(){
        return view('showNews', ['news' => News::all()->reverse()->take(5),
            'tags'=>retriveTags(),
            'details'=>Details::all()]);
    }
    public function insertNews($page){
        return view('insertScrollNews', ['news' => News::all()->reverse()->skip($page*5)->take(5),
            'tags'=>retriveTags(),
            'details'=>Details::all()]);
    }
}
