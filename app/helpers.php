<?php
use App\Models\Visit;
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
