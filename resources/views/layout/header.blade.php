<!DOCTYPE html>
<html>
<head lang="en">

    <title>news</title>
    <link rel="shortcut icon" href="/logo/logo.ico">

    <meta name="title" content="NEWS">
    <meta name="description"
          content="Foreign Exchange Market News">
    <meta name="keywords" content="News">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">
    <meta name="author" content="Payam Paydar">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/style.css?v=4.7" rel="stylesheet">
    <script src="/js/jquery.min.js"></script>
    <link href="/css/RWD.css" rel="stylesheet">
    <header>
        <div class="col-12" style="background-color: #4b5563;float: right">
            <div style="float: right;color: white;text-decoration: none; text-align: right;padding: 15px 10px 15px 0px;">
                <a  style="color: white;text-decoration: none; text-align: left;" href="/">
                    Live NEWS
                </a>
            </div>
            <div style="float: left;color: white;text-decoration: none; text-align: left;padding: 15px 10px 15px 10px;">
                @if(!Auth::check())
                <a  style="color: white;text-decoration: none; text-align: left;"
                   href="/login">
                    LOGIN
                </a>
                @else
                    <a  style="color: #ff2424;text-decoration: none; text-align: left;font-weight: bolder"
                        href="/logout">
                        LOGOUT
                    </a>
                @endif
            </div>
        </div>
    </header>
</head>
<body style="background-color: #0d1117">
