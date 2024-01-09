<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/style.css?v=1.5" rel="stylesheet">
    <link href="/css/styleLogos.css?v=1.2" rel="stylesheet">
    <link href="/css/styleNavBar.css?v=1.2" rel="stylesheet">
    <link href="/css/slideShow.css?v=1.2" rel="stylesheet">
    <link href="/css/RWD.css?v=1.2" rel="stylesheet">
    <link href="/css/messages.css?v=1.2" rel="stylesheet">
    <link href="/css/adminPanel.css?v=1.2" rel="stylesheet">
    <link href="/css/adminPanel.css?v=1.2" rel="java">
</head>
<body style="background-color: #eeeeee">

<div class="sidenav">
    <div style="background-color: #363636;padding: 0px;text-align: center">
        <a href="/" style="font-size: 25px;margin: auto;color: white;text-align: center">مشاهده وبسایت</a>
    </div>
    <div class="col-12" style="background-color: #fed000;padding: 0px;margin:auto;height: 50px;width: 100%">
        <div class="col-9">
            <a href="/admin" style="font-size: 25px;margin: auto;padding-top: 10px;padding-right: 10px;color: #ffffff">مدیریت
                سایت</a>
        </div>
        <div class="col-3" style="padding-top: 15px">
            <img src="/logo/adminPanel.png" width="30" height="20">
        </div>
    </div>

    <button class="dropdown-btn">مدیریت اخبار
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="/admin/addNews">افزودن اخبار جدید</a>
        <a class="online" href="/admin/onlineEdit">ویرایش آنلاین اخبار</a>
    </div>
    <button class="dropdown-btn">خروجی
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="/admin/exportAll">کلی</a>
        <a href="/admin/exportImportant">اخبار مهم</a>
    </div>
    <button class="dropdown-btn">مدیریت کاربر
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="/admin/addUsers">افزودن کاربر</a>
        <a href="/admin/usersPanel">مدیریت کاربر</a>
    </div>



</div>

@yield('content')
<script src="/js/canvasjs.min.js"></script>
<script src="/js/adminPanel.min.js"></script>

</body>
</html>
