<?php

use App\Models\Visit;
use App\Models\Instrument;
use App\Models\News;
use App\Models\Details;

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


function saveTags($instrument, $details_id)
{
    //جدا کردن تگ ها از یک دیگر
    $seprateTags = explode("-", $instrument);
    //هشتگ های خالی را حذف میکند.
    $seprateTags=array_filter($seprateTags);
    foreach ($seprateTags as $tag) {
        $instrument = new Instrument();
        $instrument->tag = $tag;
        $instrument->details_id = $details_id;
        $instrument->save();
    }
    return true;
}
function saveDetails($important,$effect,$comment,$details_id,$news_id)
{

    foreach ($details_id as $key => $item){
        $detail=Details::find($item);
        //اگر جزئیات جود داشت آن را ویرایش میکنیم و اگر وجود نداشت یک جزئیات جدید میسازیم.
        if($detail){
            $detail->important=$important[$key];
            $detail->effect=$effect[$key];
            $detail->comment=$comment[$key];
            $detail->news_id=$news_id;
            $detail->save();
        }
        else{
            $details=new Details();
            $details->important=$important[$key];
            $details->effect=$effect[$key];
            $details->comment=$comment[$key];
            $details->news_id=$news_id;
            $details->id=$item;
            $details->save();
        }
    }
}

function retriveTags()
{
    $arrayTags = array();
    $tags = "";
    $instruments = Instrument::all();
    $details = Details::select('id')->get();
    foreach ($details as $detail) {
        foreach ($instruments as $instrument) {
            if ($instrument->details_id == $detail->id)
                $tags .= " #" . $instrument->tag;
        }
        $arrayTags[$detail->id] = $tags;
        $tags = "";
    }
    return $arrayTags;
}

function glueTags($details_id): string
{
    $tags = "";
    $instruments = Instrument::where('details_id', '=', $details_id)->get();
    //تعداد تگ ها
    $countTags=$instruments->count();
    foreach ($instruments as $instrument) {
        if ($countTags!=1)
            $tags.=$instrument->tag.'-';
        else
            $tags.=$instrument->tag;
        //میخواهیم آخرین تگ خط تیره نخورد. احمقانه است ولی کار میکند.
        $countTags--;
    }
    return $tags;
}

function deleteTagsByNewsID($news_id){
    $tags=Instrument::join('details','instrument.details_id','=','details.id')
        ->join('news','news.id','=','details.news_id')
        ->where('news.id','=',$news_id)
        ->delete();
    return 1;
}

function deleteTagsByDetailsID($details_id){
    $tags=Instrument::where('details_id','=',$details_id)->delete();
    return 1;
}
function deleteDetailsByDetailsID($details_id){
    $tags=Details::where('id','=',$details_id)->delete();
}
function effectColors(): array
{
    return array(4 => "#167900", 3 => '#22b901', 2 => '#29e001', 1 => '#2dff00', 0 => '#ffffff', -1 => '#ff7070', -2 => '#ff5757', -3 => '#FF1919FF', -4 => '#FF0000FF');
}

function indexFields($request){
    $all = $request->all();

    //جدا کردن فیلد تگ های یک اخبار اگر چند فیلد باشد
    $pattern = '/^instrument_\d+$/';
    $filed_array = preg_grep($pattern, array_keys($all));

    $loopIndex=0;
    foreach ($filed_array as $key)
    {
        //جدا کردن عدد از ایندکس نام فیلد و استفاده از آن برای ایندکس آرایه
        $index=explode("_", $key)[1];
        $values[$loopIndex] = $index;
        $loopIndex++;
    }
    return $values;
}

function splitFileds($filedName,$request){
    $all = $request->all();

    //جدا کردن فیلد تگ های یک اخبار اگر چند فیلد باشد
    $pattern = '/^'.$filedName.'_\d+$/';
    $filed_array = preg_grep($pattern, array_keys($all));

    $index=0;
    foreach ($filed_array as $key)
    {
        //جدا کردن عدد از ایندکس نام فیلد و استفاده از آن برای ایندکس آرایه
        //$index=explode("_", $key)[1];

        $values[$index] = $all[$key];
        $index++;
    }

    return $values;
}
