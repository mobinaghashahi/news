<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function login(Request $request) //دریافت رگوئست ارسالی کاربر در صفحه ورود
    {
        $validated = $request->validate([ //داده ها رو اعتبار سنجی میکنیم
            'userName' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('userName', 'password'); //فیلد های مورد نظر رو داخل متغیر میریزیم
        if (Auth::attempt($credentials)) { //اگر کاربری با مشخصات داده شده موجود باشد نتیجه صحیح باز میگردد
            $request->session()->regenerate(); //سشن را بازسازی می کنیم
            //saveLoginLog($request->phoneNumber);
            return redirect()->intended('/'); //کاربر احراز هویت شده را با داشبورد منتقل می کنیم
        }
        return back()->withErrors([ //کاربر پیدا نشد و هنگام بازگشت به صفحه ورود خطا را نشان میدهیم
            'username' => 'Your username or password is incorrect',
        ]);
    }
    public function loginView() //دریافت رگوئست ارسالی کاربر در صفحه ورود
    {
        return view('login.login');
    }

    public function logout(Request $request)
    {
        Auth::logout(); //باطل کردن احراز هویت فعلی

        $request->session()->invalidate(); //نامعتبر سازی سشن های فعلی

        $request->session()->regenerateToken(); //تولید مجدد توکن

        return redirect('/'); //ریدایرکت کاربر به صفحه اصلی
    }
}
