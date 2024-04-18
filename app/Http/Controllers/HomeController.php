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
        /*return view('showNews', ['news' => News::all()->reverse()->take(5),
            'tags'=>retriveTags(),
            'details'=>Details::all()]);*/
        $news=News::all()->reverse()->take(5);
        return view('showNews', ['news' => $news,
            'details'=>Details::all(),
            'newsHash'=>sha1($news)]);
    }
    public function insertNews($page){
        /*return view('insertScrollNews', ['news' => News::all()->reverse()->skip($page*5)->take(5),
            'tags'=>retriveTags(),
            'details'=>Details::all()]);*/
        return view('insertScrollNews', ['news' => News::all()->reverse()->skip($page*5)->take(5),
            'details'=>Details::all()]);
    }
    public function singleBlockNews($news_id)
    {
        /*$news=News::where('id','=',$news_id)->get();

        //برای دیلیت کردن اخبار
        if($news->count()==0)
            return null;

        return view('singleBlockNews', ['news' => $news,
            'tags'=>retriveTags(),
            'details'=>Details::all()]);*/

        $news=News::where('id','=',$news_id)->get();

        //برای دیلیت کردن اخبار
        if($news->count()==0)
            return null;

        return view('singleBlockNews', ['news' => $news,
            'details'=>Details::all()]);

    }
    public function multiBlockNews($page)
    {
        $page=$page+1;
        return view('multiBlockNews', ['news' => News::all()->reverse()->take($page*5),
            'details'=>Details::all()]);
    }

    public function addNewNewsBlock()
    {
        /*return view('addNewNewsBlock', ['news' => News::get()->last(),
            'tags'=>retriveTags(),
            'details'=>Details::all()]);*/
        return view('addNewNewsBlock', ['news' => News::get()->last(),
            'details'=>Details::all()]);
    }
    public function transferData(){
        $details=Details::join('instrument', 'details.id', '=', 'instrument.details_id')
            ->select('details.news_id as news_id','details.id as detailsID','instrument.id as instrumentID','instrument.tag as tag')
            ->get();
        foreach ($details as $detail) {
            $details2 = Details::findOrFail($detail['detailsID']);
            $details2->instrument=$detail['tag'];
            $details2->save();
        }

        //OLD CODE
        /*$details=Details::join('instrument', 'details.id', '=', 'instrument.details_id')
            ->select()
            ->get();
        foreach ($details as $detail) {
            $news = News::findOrFail($detail->news_id);
            $news->instrument=$detail->tag;
            $news->save();
        }*/
    }
    public function getNewsHash($page){
        $news=News::all()->reverse()->take($page*5);
        return sha1($news);
    }
}
