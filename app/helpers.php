<?php

use App\Models\Visit;
use App\Models\Instrument;
use App\Models\News;

function visitedMonthAgo(): array
{
    //this is for fix groupBy error!!!!!
    \DB::statement("SET SQL_MODE=''");

    $countVisit = array();
    $v = Verta::now();
    $visitQuary = Visit::where('date', 'like', '%' . $v->format('Y-m-d') . '%')->groupBy('ip')->get()->count();
    array_push($countVisit, array($v->format('Y-m-d'), $visitQuary));
    for ($i = 1; $i <= 30; $i++) {
        $date = $v->subDay(1)->format('Y-m-d');
        $visitQuary = Visit::where('date', 'like', '%' . $date . '%')->groupBy('ip')->get()->count();
        array_push($countVisit, array($date, $visitQuary));
    }
    return $countVisit;
}


function saveTags($text, $news_id)
{

    //جدا کردن تگ ها از یک دیگر
    $seprateTags = explode("-", $text);
    foreach ($seprateTags as $tag) {
        $instrument = new Instrument();
        $instrument->tag = $tag;
        $instrument->news_id = $news_id;
        $instrument->save();
        echo $tag;
    }
    return true;
}

function retriveTags()
{
    $arrayTags=array();
    $tags="";
    $instruments = Instrument::all();
    $news = News::select('id')->get();
    foreach ($news as $new){
        foreach ($instruments as $instrument){
            if($instrument->news_id==$new->id)
                $tags.=" #".$instrument->tag;
        }
        $arrayTags[$new->id]=$tags;
        $tags="";
    }
    return $arrayTags;

}
