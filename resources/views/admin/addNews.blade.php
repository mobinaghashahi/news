@extends('admin.menu')
@section('content')
    <div class="main">
        <div class="col-12" style="text-align: center;padding-top: 15px;">
            <a style="background-color: #363636;padding: 10px;border-radius: 5px;color: white">افزودن اخبار جدید</a>
        </div>
        <div class="blockOfInputs">
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

            <form method="post" name="enter" id="form" enctype="multipart/form-data" action="/admin/addNews">
                @csrf
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="title" style="text-align: center" class="inputText" placeholder="title">
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="effect" style="text-align: center" class="inputText" placeholder="effect">
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="comment" style="text-align: center" class="inputText" placeholder="comment">
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="instrument" style="text-align: center" class="inputText" placeholder="instrument">
                    </div>
                </div>
                <div class="col-12 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-8">
                        <textarea name="text" class="inputText" style="text-align: left;direction:ltr;text-align: justify;max-width: 100%;min-width: 100%"
                                  placeholder="news text"></textarea>
                    </div>
                </div>

                <div class="col-12 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-3" style="text-align: center">
                        <label>Important</label>
                        <input type="checkbox" id="important" name="important" value="1">
                    </div>
                </div>
                <div class="col-12" style="padding-top: 10px;display: flex;justify-content: center">
                    <div class="col-3">
                        <input class="inputSubmit" type="button" value="افزودن">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/js/reconnecting-websocket.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script>
        var conn = new ReconnectingWebSocket('ws://82.115.16.178:1020');
        conn.onopen = function(e) {
            console.log("Connection stablished");
        }
        $(document).ready(function () {
                $("body").on('click', '.inputSubmit', function (e) { // changed
                    $.ajax({
                        type: "POST",
                        url: "/admin/addNews",
                        data: $(this).closest("form").serialize(), // changed
                        success: function (data) {
                            //console.log('newsMessage');
                            //location.reload()
                            //document.getElementById(newsID).innerHTML=data;
                            conn.send('new');

                            //clearForm()

                            //$(divID).replaceWith(data);
                            /*console.log(element)
                            $(element).animate({backgroundColor: "#eeeeee"});*/
                        }
                    });

                });
        });

        function clearForm(){
            var elements = document.getElementsByTagName("input");
            for (var ii=0; ii < elements.length; ii++) {
                if (elements[ii].type == "text"||elements[ii].type == "textarea") {
                    elements[ii].value = "";
                }
            }
            $("#form").find("input[type=text], textarea").val("");
        }
    </script>
@endsection
