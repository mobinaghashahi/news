<?php

namespace App\Http\Controllers;

use App\Models\Details;
use App\Models\Instrument;
use App\Models\News;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

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
    public function singleBlockNews($news_id)
    {
        $news=News::where('id','=',$news_id)->get();

        //برای دیلیت کردن اخبار
        if(isNull($news))
            return null;

        return view('singleBlockNews', ['news' => $news,
            'tags'=>retriveTags(),
            'details'=>Details::all()]);
    }

    public function addNewNewsBlock()
    {
        return view('addNewNewsBlock', ['news' => News::get()->last(),
            'tags'=>retriveTags(),
            'details'=>Details::all()]);
    }
}
