<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SocketController;
use App\Models\Details;
use App\Models\News;
use App\Models\Instrument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use function React\Promise\all;

class Admin extends Controller
{
    public function showDashboard()
    {
        return view('admin.dashboard', [
            'visitedMonthAgo' => visitedMonthAgo(),
        ]);
    }

    public function showAddNewsForm()
    {
        return view('admin.addNews');
    }

    public function addNews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'effect' => 'required|integer',
            'text' => 'required'
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->text = $request->text;
        $news->user_id = Auth::user()->id;
        $news->save();

        //ذخیره جزئیات خبر
        $details = new Details();
        $details->effect = $request->effect;
        $details->comment = $request->comment;
        $details->news_id = $news->id;
        $details->instrument = $request->instrument;
        //اگر تیک important زده شده بود مقدار یک را ذخیره میکنیم و اگر زده نشده بود مقدار 0
        if (isset($request->important))
            $details->important = 1;
        else
            $details->important = 0;
        $details->save();


        return redirect()->intended('/admin/addNews')->with('msg', 'خبر با موفقیت افزوده شد.');

    }

    public function onlineEdit(Request $request)
    {
        $searchText = $request->searchText;


        // آرایه‌ای از مقادیر instruments که می‌خواهید فیلتر کنید
        $Filters = array_keys($request->all()); // مقادیر فیلتر ارسال شده از فرم فیلتر
        $keysToExpect = ['applyFilters', 'important','searchText'];
        $lastInstrumentsFilters = array_diff($Filters, $keysToExpect);
        $lastImportantState = $request->important;
        //choice any instruments and apply filters
        if (!empty($lastInstrumentsFilters)) {
            //if user choice both (important and notImportant)
            if ($request->important == 'both' or empty($request->important)) {
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            } //if user choice one of important OR notImportant
            else if ($request->important == 'important' or $request->important == 'notImportant') {
                $important = ['important' => 1, 'notImportant' => 0];
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                    ->where('details.important', $important[$request->important])// اعمال شرط برای important
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }
        }

        elseif (!empty($searchText)){
            $searchText=$request->searchText;

            $filteredNews = News::select('news.id', 'news.text', 'news.created_at', 'news.title')
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
            $newsIds = $filteredNews->pluck('id'); // استخراج شناسه‌های اخبار
            $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار
            //use for checkbox filters
            $instruments=Details::whereNot('instrument','=','')
                ->select('instrument')
                ->groupBy('instrument')
                ->get();
        } elseif (empty($lastInstrumentsFilters)) {
            //if user choice both (important and notImportant)
            if ($request->important == 'both' or empty($request->important)) {
                $filteredNews = News::select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            } //if user choice one of important OR notImportant
            else if ($request->important == 'important' or $request->important == 'notImportant') {
                $important = ['important' => 1, 'notImportant' => 0];
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->where('details.important', $important[$request->important])// اعمال شرط برای important
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }
        }

        $newsIds = $filteredNews->pluck('id'); // استخراج شناسه‌های اخبار
        $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار

        return view('admin.onlineEdit', ['news' => $filteredNews,
            'details' => $details,
            'lastInstrumentsFilters' => $lastInstrumentsFilters,
            'lastImportantState' => $lastImportantState,
            'lastDetailsID' => Details::orderBy('id')
                ->get('id')
                ->reverse()
                ->first(),
            'instruments' => Details::whereNot('instrument', '=', '')
                ->select('instrument')
                ->groupBy('instrument')
                ->get(),
            'searchText'=>$searchText,
            'urlActionSearch' => '/admin/onlineEdit'
        ]);
    }

    public function editNews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'text' => 'required'
        ]);

        $news = News::findOrFail($request->id);
        $news->title = $request->title;
        $news->text = $request->text;
        $news->user_id = Auth::user()->id;
        $news->save();


        //ذخیره کردن details
        $news_id = $request->id;
        saveDetails(splitFileds('important', $request), splitFileds('effect', $request), splitFileds('comment', $request), splitFileds('idDetails', $request), splitFileds('instrument', $request), $news_id);

        //ذخیره کردن هشتگ ها
        $index = 0;
        $instrumentsArray = splitFileds('instrument', $request);
        foreach ($instrumentsArray as $instrument) {
            saveTags($instrument, splitFileds('idDetails', $request)[$index]);
            $index++;
        }


        return redirect()->intended('/admin/onlineEdit')->with('msg', 'خبر با موفقیت افزوده شد.');
    }

    public function insertScrollNews(Request $request)
    {
        $searchText = $request->searchText;

        // آرایه‌ای از مقادیر instruments که می‌خواهید فیلتر کنید
        $Filters = array_keys($request->all()); // مقادیر فیلتر ارسال شده از فرم فیلتر
        $keysToExpect = ['applyFilters', 'important', 'page','searchText'];
        $lastInstrumentsFilters = array_diff($Filters, $keysToExpect);
        $lastImportantState = $request->important;
        // برای برگرداندن خبر بر اساس هشتگ های فیلتر شده
        if(!empty($lastInstrumentsFilters)) {
            //if user choice both (important and notImportant)
            if ($lastImportantState == 'both' or $lastImportantState == "null") {
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->groupBy('news.text')
                    ->groupBy('news.title')
                    ->groupBy('news.created_at')
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->skip($request->page * 20)
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            } //if user choice one of important OR notImportant
            else if ($lastImportantState == 'important' or $lastImportantState == 'notImportant') {
                $important = ['important' => 1, 'notImportant' => 0];
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->whereIn('details.instrument', $lastInstrumentsFilters) // اعمال شرط بر روی instruments
                    ->where('details.important', $important[$lastImportantState])// اعمال شرط برای important
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->groupBy('news.text')
                    ->groupBy('news.title')
                    ->groupBy('news.created_at')
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->skip($request->page * 20)
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }
        }
        //برای جست و جو با کلمه سرچ شده
        elseif (!empty($searchText) AND $searchText!="null"){
            $searchText=$request->searchText;

            $filteredNews = News::select('news.id', 'news.text', 'news.created_at', 'news.title')
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
                ->skip($request->page * 20)
                ->take(20)
                ->get();
            $newsIds = $filteredNews->pluck('id'); // استخراج شناسه‌های اخبار
            $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار
            //use for checkbox filters
            $instruments=Details::whereNot('instrument','=','')
                ->select('instrument')
                ->groupBy('instrument')
                ->get();
        } elseif(empty($lastInstrumentsFilters)) {
            //if user choice both (important and notImportant)
            if ($request->important == 'both' or $lastImportantState == "null") {
                $filteredNews = News::select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->groupBy('news.text')
                    ->groupBy('news.title')
                    ->groupBy('news.created_at')
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->skip($request->page * 20)
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            } //if user choice one of important OR notImportant
            else if ($lastImportantState == 'important' or $lastImportantState == 'notImportant') {
                $important = ['important' => 1, 'notImportant' => 0];
                $filteredNews = News::join('details', 'details.news_id', '=', 'news.id')
                    ->select('news.id as id', 'news.text as text', 'news.created_at as created_at', 'news.title as title')
                    ->where('details.important', $important[$lastImportantState])// اعمال شرط برای important
                    ->groupBy('news.id') // گروه‌بندی بر اساس news.id
                    ->groupBy('news.text')
                    ->groupBy('news.title')
                    ->groupBy('news.created_at')
                    ->orderBy('news.id', 'desc') // مرتب‌سازی نزولی
                    ->skip($request->page * 20)
                    ->take(20) // گرفتن 20 رکورد
                    ->get(); // اجرا و دریافت نتایج
            }
        }



        $newsIds = $filteredNews->pluck('id'); // استخراج شناسه‌های اخبار
        $details = Details::whereIn('news_id', $newsIds)->get(); // فیلتر کردن details بر اساس شناسه‌های اخبار

        return view('admin.insertScrollNews', ['news' => $filteredNews,
            'details' => $details]);
    }

    public function addDetailsForm($news_id)
    {
        //ذخیره جزئیات خبر
        $details = new Details();
        $details->effect = '4';
        $details->comment = '';
        $details->news_id = $news_id;
        $details->instrument = '';
        $details->important = 0;
        $details->save();
        return view('admin.addDetailsForm', ['details_id' => $details->id]);
    }

    public function deleteDetailsForm($details_id)
    {
        deleteTagsByDetailsID($details_id);
        return deleteDetailsByDetailsID($details_id);
    }

    public function deleteNewsForm($news_id)
    {
        News::where('id', '=', $news_id)->delete();
        return true;
    }

    public function usersPanel()
    {
        return view('admin.usersPanel', ['users' => User::all()]);
    }

    public function deleteUser($user_id)
    {
        $user = User::findOrFail($user_id);
        try {

            $user->delete();

        } catch (\Exception $e) {
            $errors = new MessageBag([
                'badRequest' => ['شما مجاز به انجام این عملیات نیستید.'],
            ]);
            return redirect()->intended('/admin/usersPanel')->with('errors', $errors);
        }

        return redirect()->intended('admin/usersPanel')->with('msg', 'کاربر با موفقیت حذف شد.');
    }

    public function addUserForm()
    {
        return view('admin.addUserForm');
    }

    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'userName' => 'required|unique:users',
            'password' => 'required',
            'type' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->userName = $request->userName;
        $user->password = Hash::make($request->password);
        $user->type = $request->type;
        $user->save();
        return redirect()->intended('admin/usersPanel')->with('msg', 'کاربر با موفقیت افزوده شد.');
    }

    public function editUserForm($user_id)
    {
        return view('admin.editUserForm', ['user' => User::where('id', '=', $user_id)->get()]);
    }

    public function editUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'userName' => 'required',
            'type' => 'required',
            'userID' => 'required',
        ]);

        $user = User::findOrFail($request->userID);
        $user->name = $request->name;
        $user->userName = $request->userName;
        $user->type = $request->type;

        if (!empty($request->password))
            $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->intended('admin/editUserForm/' . $request->userID)->with('msg', 'کاربر با موفقیت ویرایش شد.');
    }
}
