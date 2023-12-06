<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $news->effect = $request->effect;
        $news->comment = $request->comment;
        $news->text = $request->text;
        $news->user_id = Auth::user()->id;
        //اگر تیک important زده شده بود مقدار یک را ذخیره میکنیم و اگر زده نشده بود مقدار 0
        if (isset($request->important))
            $news->important = 1;
        else
            $news->important = 0;
        $news->save();

        //ذخیره کردن هشتگ ها
        saveTags($request->instrument, $news->id);

        return redirect()->intended('/admin/addNews')->with('msg', 'خبر با موفقیت افزوده شد.');

    }

    public function onlineEdit()
    {
        glueTags(8);
        return view('admin.onlineEdit', ['news' => News::all()->reverse(),
            'tags' => retriveTags()]);
    }

    public function editNews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'effect' => 'required|integer',
            'text' => 'required'
        ]);

        $news = News::findOrFail($request->id);
        $news->title = $request->title;
        $news->effect = $request->effect;
        $news->comment = $request->comment;
        $news->text = $request->text;
        $news->user_id = Auth::user()->id;
        //اگر تیک important زده شده بود مقدار یک را ذخیره میکنیم و اگر زده نشده بود مقدار 0
        if (isset($request->important))
            $news->important = 1;
        else
            $news->important = 0;
        $news->save();

        //حذف کردن تگ های قبلی
        deleteTags($request->id);
        //ذخیره کردن هشتگ ها
        saveTags($request->instrument, $news->id);

        return redirect()->intended('/admin/onlineEdit')->with('msg', 'خبر با موفقیت افزوده شد.');
    }
}
