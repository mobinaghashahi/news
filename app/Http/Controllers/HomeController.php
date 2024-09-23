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
        $news = News::all()->reverse()->take(20); // گرفتن 20 خبر آخر
        $newsIds = $news->pluck('id'); // استخراج شناسه‌های اخبار
        $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار

        //use for checkbox filters
        $instruments=Details::whereNot('instrument','=','')
            ->select('instrument')
            ->groupBy('instrument')
            ->get();

        return view('showNews', ['news' => $news,
            'details'=>$details,
            'newsHash'=>sha1($news),
            'lastInstrumentsFilters'=>[],
            'lastImportantState'=>'both',
            'instruments'=>$instruments,
            'urlActionSearch'=>'/searchResult']);
    }
    public function insertNews($page){
        /*return view('insertScrollNews', ['news' => News::all()->reverse()->skip($page*5)->take(5),
            'tags'=>retriveTags(),
            'details'=>Details::all()]);*/
        $news = News::all()->reverse()->skip($page*20)->take(20);
        $newsIds = $news->pluck('id'); // استخراج شناسه‌های اخبار
        $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار
        return view('insertScrollNews', ['news' => $news,
            'details'=>$details]);
    }

    public function showFilterNews(Request $request){
        \DB::statement("SET SQL_MODE=''");


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
            if(empty($lastInstrumentsFilters)){
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id','news.text as text','news.created_at as created_at','news.title as title')
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }else{
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id','news.text as text','news.created_at as created_at','news.title as title')
                    ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }

        }
        else if($request->important=='important' OR $request->important=='notImportant'){
            $important=['important'=>1,'notImportant'=>0];
            if(empty($lastInstrumentsFilters)) {
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->where('details.important', $important[$request->important])// اعمال شرط برای important
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }
            else{
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                    ->where('details.important', $important[$request->important])// اعمال شرط برای important
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }
        }
        $newsIds = $filteredNews->pluck('id'); // استخراج شناسه‌های اخبار
        $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار
        return view('showFilterNews', ['news' => $filteredNews,
            'details'=>$details,
            'newsHash'=>sha1($filteredNews),
            'lastInstrumentsFilters'=>$lastInstrumentsFilters,
            'lastImportantState'=>$lastImportantState,
            'instruments'=>$instruments,
            'urlActionSearch'=>'/searchResult']);
    }
    public function insertScrollNewsWhitFilters(Request $request){
        \DB::statement("SET SQL_MODE=''");

        // آرایه‌ای از مقادیر instruments که می‌خواهید فیلتر کنید
        $Filters = array_keys($request->all()); // مقادیر فیلتر ارسال شده از فرم فیلتر
        $keysToExpect=['applyFilters','important','page'];
        $lastInstrumentsFilters=array_diff($Filters, $keysToExpect);
        $lastImportantState=$request->important;

        //جداسازی دو حالت برای اخبار مهم، غیر مهم و هردو اخبار مهم و غیر مهم
        if($request->important=='both'){
            if(empty($lastInstrumentsFilters)){
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id','news.text as text','news.created_at as created_at','news.title as title')
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->skip($request->page*20)
                    ->get(); // اجرا و دریافت نتایج
            }else{
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id','news.text as text','news.created_at as created_at','news.title as title')
                    ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->skip($request->page*20)
                    ->get(); // اجرا و دریافت نتایج
            }

        }
        else if($request->important=='important' OR $request->important=='notImportant'){
            $important=['important'=>1,'notImportant'=>0];
            if(empty($lastInstrumentsFilters)){
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id','news.text as text','news.created_at as created_at','news.title as title')
                    ->where('details.important', $important[$request->important])// اعمال شرط برای important
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->skip($request->page*20)
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }else{
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id','news.text as text','news.created_at as created_at','news.title as title')
                    ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                    ->where('details.important', $important[$request->important])// اعمال شرط برای important
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->skip($request->page*20)
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }

        }
        $newsIds = $filteredNews->pluck('id'); // استخراج شناسه‌های اخبار
        $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار

        return view('insertScrollNewsWhitFilters', ['news' => $filteredNews,
            'details'=>$details]);
    }

    public function searchResultNews(Request $request){

        $searchText=$request->searchText;

        $news = News::select('news.id', 'news.text', 'news.created_at', 'news.title')
            ->join('details', 'details.news_id', '=', 'news.id')
            ->where('news.text', 'like', '%' . $searchText . '%')
            ->orWhere('news.title', 'like', '%' . $searchText . '%')
            ->orWhere('news.created_at', 'like', '%' . $searchText . '%')
            ->orWhere('details.instrument', 'like', '%' . $searchText . '%')
            ->groupBy('news.id') // گروه‌بندی بر اساس news.id
            ->groupBy('news.text')
            ->groupBy('news.title')
            ->groupBy('news.created_at')
            ->orderBy('news.created_at', 'desc')
            ->orderBy('news.id', 'desc')
            ->take(20)
            ->get();



        $newsIds = $news->pluck('id'); // استخراج شناسه‌های اخبار
        $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار
        //use for checkbox filters
        $instruments=Details::whereNot('instrument','=','')
            ->select('instrument')
            ->groupBy('instrument')
            ->get();

        return view('searchResult', ['news' => $news,
            'details'=>$details,
            'newsHash'=>sha1($news),
            'lastInstrumentsFilters'=>[],
            'lastImportantState'=>'both',
            'instruments'=>$instruments,
            'searchText'=>$searchText,
            'urlActionSearch'=>'/searchResult']);
    }
    public function insertSearchScrollNews(Request $request){
        $page=$request->page;
        $searchText=$request->searchText;

        $news =News::select('news.id', 'news.text', 'news.created_at', 'news.title')
            ->join('details', 'details.news_id', '=', 'news.id')
            ->where('news.text', 'like', '%' . $searchText . '%')
            ->orWhere('news.title', 'like', '%' . $searchText . '%')
            ->orWhere('news.created_at', 'like', '%' . $searchText . '%')
            ->orWhere('details.instrument', 'like', '%' . $searchText . '%')
            ->groupBy('news.id') // گروه‌بندی بر اساس news.id
            ->groupBy('news.text')
            ->groupBy('news.title')
            ->groupBy('news.created_at')
            ->orderBy('news.created_at', 'desc')
            ->orderBy('news.id', 'desc')
            ->skip($page*20)
            ->take(20)
            ->get();

        $newsIds = $news->pluck('id'); // استخراج شناسه‌های اخبار

        $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار
        return view('insertScrollNews', ['news' => $news,
            'details'=>$details]);
    }


    public function singleBlockNews($news_id)
    {

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

    }
    public function getNewsHash($page){
        $news=News::all()->reverse()->take($page*20);
        return sha1($news);
    }
}
