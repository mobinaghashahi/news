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
        $news=News::all()->reverse()->take(5);
        //use for checkbox filters
        $instruments=Details::whereNot('instrument','=','')
            ->select('instrument')
            ->groupBy('instrument')
            ->get();

        return view('showNews', ['news' => $news,
            'details'=>Details::all(),
            'newsHash'=>sha1($news),
            'lastInstrumentsFilters'=>[],
            'lastImportantState'=>'both',
            'instruments'=>$instruments]);
    }
    public function insertNews($page){
        /*return view('insertScrollNews', ['news' => News::all()->reverse()->skip($page*5)->take(5),
            'tags'=>retriveTags(),
            'details'=>Details::all()]);*/
        return view('insertScrollNews', ['news' => News::all()->reverse()->skip($page*5)->take(5),
            'details'=>Details::all()]);
    }

    public function showFilterNews(Request $request){

        //use for checkbox filters
        $instruments=Details::whereNot('instrument','=','')
            ->select('instrument')
            ->groupBy('instrument')
            ->get();

        // آرایه‌ای از مقادیر instruments که می‌خواهید فیلتر کنید
        $Filters = array_keys($request->all()); // مقادیر فیلتر ارسال شده از فرم فیلتر
        $keysToExpect=['applyFilters','important'];
        $lastInstrumentsFilters=array_diff($Filters, $keysToExpect);
        $lastImportantState=$request->important;

        //جداسازی دو حالت برای اخبار مهم، غیر مهم و هردو اخبار مهم و غیر مهم
        if($request->important=='both'){
            $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                ->select('news.id as id','news.text as text','news.created_at as created_at')
                ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                ->take(20) // گرفتن 20 رکورد
                ->get(); // اجرا و دریافت نتایج
        }
        else if($request->important=='important' OR $request->important=='notImportant'){
            $important=['important'=>1,'notImportant'=>0];
            $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                ->select('news.id as id','news.text as text','news.created_at as created_at')
                ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                ->where('details.important', $important[$request->important])// اعمال شرط برای important
                ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                ->take(20) // گرفتن 20 رکورد
                ->get(); // اجرا و دریافت نتایج
        }

        return view('showFilterNews', ['news' => $filteredNews,
            'details'=>Details::all(),
            'newsHash'=>sha1($filteredNews),
            'lastInstrumentsFilters'=>$lastInstrumentsFilters,
            'lastImportantState'=>$lastImportantState,
            'instruments'=>$instruments]);
    }
    public function insertScrollNewsWhitFilters(Request $request){
        // آرایه‌ای از مقادیر instruments که می‌خواهید فیلتر کنید
        $Filters = array_keys($request->all()); // مقادیر فیلتر ارسال شده از فرم فیلتر
        $keysToExpect=['applyFilters','important'];
        $lastInstrumentsFilters=array_diff($Filters, $keysToExpect);
        $lastImportantState=$request->important;

        //جداسازی دو حالت برای اخبار مهم، غیر مهم و هردو اخبار مهم و غیر مهم
        if($request->important=='both'){
            $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                ->select('news.id as id','news.text as text','news.created_at as created_at')
                ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                ->take(20) // گرفتن 20 رکورد
                ->skip($request->page*5)
                ->get(); // اجرا و دریافت نتایج
        }
        else if($request->important=='important' OR $request->important=='notImportant'){
            $important=['important'=>1,'notImportant'=>0];
            $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                ->select('news.id as id','news.text as text','news.created_at as created_at')
                ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                ->where('details.important', $important[$request->important])// اعمال شرط برای important
                ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                ->skip($request->page*5)
                ->take(20) // گرفتن 20 رکورد
                ->get(); // اجرا و دریافت نتایج
        }

        return view('insertScrollNewsWhitFilters', ['news' => $filteredNews,
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
