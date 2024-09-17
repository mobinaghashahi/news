<!DOCTYPE html>
<html>
<head lang="en">

    <title>news</title>

    <meta name="title" content="NEWS">
    <meta name="description"
          content="Foreign Exchange Market News">
    <meta name="keywords" content="News">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">
    <meta name="author" content="Payam Paydar">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/style.css?v=5.3" rel="stylesheet">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/reconnecting-websocket.js"></script>
    <!-- لینک به کتابخانه Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="/css/RWD.css" rel="stylesheet">
    <header>
        <div class="col-12" style="background-color: #4b5563;float: right;padding: 10px 0px 1px 0px">
            <div class="col-4"
                 style="float: left;color: white;text-decoration: none; text-align: left;padding: 15px 0px 15px 0px;">
                @if(!Auth::check())
                    <a style="color: white;text-decoration: none; text-align: left;position: relative;left: 20px"
                       href="/login">
                        LOGIN
                    </a>
                @else
                    <a style="color: #ff2424;text-decoration: none; text-align: left;font-weight: bolder;position: relative;left: 20px"
                       href="/logout">
                        LOGOUT
                    </a>
                @endif
            </div>
            <div class="col-4" style="padding: 0px 0px 10px 0px;float: left">
                <form method="get" action="{{$urlActionSearch}}">
                    <div class="search-container">
                        <i class="fas fa-search icon"></i> <!-- آیکون ذره‌بین -->
                        <input name="searchText" type="text" value="{{ $searchText ?? '' }}" placeholder="Search">
                    </div>
                </form>
            </div>
            <div class="col-4"
                 style="float: left;color: white;text-decoration: none; text-align: right; padding-top: 15px">
                <a style="color: white;text-decoration: none; text-align: left;position: relative;right: 20px"
                href="/">
                Live NEWS
                </a>
            </div>

        </div>
    </header>
</head>
<body style="background-color: #0d1117">
