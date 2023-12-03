@extends('admin.menu')
@section('content')
    <script>
        window.onload = function () {
            var chart1 = new CanvasJS.Chart("chartVisit", {
                animationEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                data: [{
                    type: "column",
                    legendMarkerColor: "grey",
                    legendText: "MMbbl = one million barrels",
                    dataPoints: [
                            @for($i=30;$i>=0;$i--)
                        {
                            y: {{$visitedMonthAgo[$i][1]}}, label: '{{$visitedMonthAgo[$i][0]}}'
                        },
                        @endfor
                    ]
                }]
            });
            chart1.render();
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div id="enterPostBlock" class="col-3"
         style="display:none;position: absolute;top:35%;left: 30%;background-color: #FB8500;border-radius: 10px;text-align: center;padding: 20px;z-index: 1">
        <form action="/admin/sendProduct" method="post">
            @csrf
            <div class="col-1">
                <div id="closeEnterPostForm" class="col-12" style="float: right;cursor: pointer;">
                    <img src="/logo/deleteRed.png" width="25" height="25">
                </div>
            </div>
            <div class="col-12" style="margin-bottom: 10px">
                <label style="color: white;">کد پیگیری پست</label>
            </div>
            <div class="col-12">
                <input type="text" class="inputText" name="postCode" id="postCode">
            </div>
            <input style="visibility: hidden" type="text" class="inputText" name="idProduct" id="idProducts">
            <div class="col-12" style="display: flex;justify-content: center;padding-top: 10px;padding-bottom: 15px;">
                <input
                    style=";background-image: linear-gradient(45deg, #45cb1b 0%, #408500 51%, #43c200 100%);text-align: center"
                    class="inputSubmit" name="enter" type="submit" value="ثبت">
            </div>
            <script>
                $(document).ready(function () {
                    $("#closeEnterPostForm").click(function () {
                        $("#enterPostBlock").css('display', 'none');
                        $("#main").css('filter', 'blur(0px)');
                        $("#main").css('pointer-events', 'auto');
                    });

                    $(".sendProduct").click(function () {
                        $("#enterPostBlock").css('display', 'block');
                        $("#idProducts").val($(this).attr("id"));
                        $("#main").css('filter', 'blur(3px)');
                        $("#main").css('pointer-events', 'none');
                    });


                });

                $(window).on("load", function () {
                    let progressBarLength = $("#postCode").val().length;
                    let progressBarPercent = 0;
                    if (progressBarLength < 16 && progressBarLength != 0) {
                        progressBarPercent = progressBarLength * 6.25;
                        $('#progressBar').css('background-color', 'red');
                    } else if (progressBarLength === 16) {
                        progressBarPercent = 100;
                        $('#progressBar').css('background-color', 'green');
                    } else if (progressBarLength === 0) {
                        progressBarPercent = 1;
                    }
                    $('#truck').css('left', parseInt(progressBarPercent - progressBarLength) + '%');
                    $('#progressBar').css('width', progressBarPercent + '%');
                });

            </script>
        </form>
    </div>
    <div id="main" class="main col-10" style="float: left; ">
        @if (\Session::has('msg'))
            <div class="notification notificationSuccess">
                <p>{!! \Session::get('msg') !!}</p>
                <span class="notification_progress"></span>
            </div>
        @endif
        @if ($errors->any())
            @foreach($errors->all() as $error)
                <div class="notification notificationError">
                    <p>{{$error}}</p>
                    <span class="notification_progress"></span>
                </div>
            @endforeach
        @endif
        <h2 style="text-align: center">به پنل مدیریتی خوش آمدید</h2>
        <div class="col-12"
             style="margin-top:20px;background-color: #373f4d;display: flex;justify-content: center;padding-top: 10px;padding-bottom:30px;border-radius: 10px">
            <div class="col-11">
                <div class="col-12" style="display: flex;justify-content: center">
                    <div class="col-3" style="font-size: 25px">
                        <p style="text-align: center;color: white;font-size: larger;text-shadow: 2px 0 black">گزارش
                            بازدید</p>
                    </div>
                </div>
                <div class="col-12">
                    <div  id="chartVisit" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
