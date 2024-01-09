<?php

namespace App\Http\Controllers;
use App\Http\Controllers\SocketController;
use App\Models\Details;
use App\Models\News;
use App\Models\Instrument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;

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
        //اگر تیک important زده شده بود مقدار یک را ذخیره میکنیم و اگر زده نشده بود مقدار 0
        if (isset($request->important))
            $details->important = 1;
        else
            $details->important = 0;
        $details->save();


        //ذخیره کردن هشتگ ها
        saveTags($request->instrument, $details->id);


        return redirect()->intended('/admin/addNews')->with('msg', 'خبر با موفقیت افزوده شد.');

    }

    public function onlineEdit()
    {
        return view('admin.onlineEdit', ['news' => News::all()->reverse()->take(5),
            'tags' => retriveTags(),
            'details' => Details::all(),
            'lastDetailsID' => Details::orderBy('id')
                ->get('id')->reverse()->first()]);
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

        //حذف کردن تگ ها قبلی خبر
        deleteTagsByNewsID($news->id);

        //ذخیره کردن details
        $news_id = $request->id;
        saveDetails(splitFileds('important', $request), splitFileds('effect', $request), splitFileds('comment', $request), splitFileds('idDetails', $request), $news_id);

        //ذخیره کردن هشتگ ها
        $index=0;
        $instrumentsArray = splitFileds('instrument', $request);
        foreach ($instrumentsArray as $instrument) {
            saveTags($instrument, splitFileds('idDetails', $request)[$index]);
            $index++;
        }


        return redirect()->intended('/admin/onlineEdit')->with('msg', 'خبر با موفقیت افزوده شد.');
    }

    public function insertScrollNews($page)
    {
        return view('admin.insertScrollNews', ['news' => News::all()->reverse()->skip($page * 5)->take(5),
            'tags' => retriveTags(),
            'details' => Details::all()]);
    }

    public function addDetailsForm($details_id)
    {
        return view('admin.addDetailsForm', ['details_id' => $details_id]);
    }

    public function deleteDetailsForm($details_id)
    {
        deleteTagsByDetailsID($details_id);
        deleteDetailsByDetailsID($details_id);
        return true;
    }

    public function deleteNewsForm($news_id)
    {
        News::where('id','=',$news_id)->delete();
        return true;
    }

    public function usersPanel()
    {
        return view('admin.usersPanel', ['users' => User::all()]);
    }

    public function deleteUser($user_id)
    {
        $user=User::findOrFail($user_id);
        try {

            $user->delete();

        } catch (\Exception $e) {
            $errors = new MessageBag([
                'badRequest' => ['شما مجاز به انجام این عملیات نیستید.'],
            ]);
            return redirect()->intended('/admin/usersPanel')->with('errors', $errors);
        }

        return redirect()->intended('admin/usersPanel')->with('msg','کاربر با موفقیت حذف شد.');
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
        $user->name= $request->name;
        $user->userName= $request->userName;
        $user->password= Hash::make($request->password);
        $user->type= $request->type;
        $user->save();
        return redirect()->intended('admin/usersPanel')->with('msg','کاربر با موفقیت افزوده شد.');
    }
}
