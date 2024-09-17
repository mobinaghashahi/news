
@extends('layout.master')
@section('content')

    @include('filterNewsForm',["url" => "/admin/onlineEdit"])
    @foreach($news as $new)
        <form method="post" name="enter" id="news_{{$new->id}}">
            @csrf
            <div class="col-12" style="justify-content: center;display: flex;color: #ff0000">
                <input type="text" name="id" value="{{$new->id}}" hidden>
                <div class="col-6 blockNews">
                    <div class="col-2">
                        <a class="deleteNews" style="cursor: pointer">
                            <img src="/logo/deleteRed.png" width="20" height="20" style="float: right">
                            <input type="text" name="{{$new->id}}"
                                   value="{{$new->id}}" hidden>
                        </a>
                    </div>
                    <div class="col-12 titleTextInput" style="display: flex;justify-content: center">
                        <div class="col-8">
                        <textarea id="text{{$new->id}}" name="text" class="inputText"
                                  style="text-align: left;direction:ltr;text-align: justify;max-width: 100%;min-width: 100%;height: 100px"
                                  placeholder="news text">{{$new->text}}</textarea>
                        </div>
                    </div>
                    <div class="bottomBlockNews">
                        <div class="col-12">
                            <a>TITLE: <input name="title" class="inputText" placeholder="TITLE"
                                             value="{{$new->title}}"></a>
                        </div>
                        <div class="col-12">
                            <a>DATE: {{$new->created_at}}</a>
                        </div>

                        <div class="col-12" id="{{$new->id}}" style="padding-top: 5px">
                            @foreach($details as $detail)
                                @if($detail->news_id==$new->id)
                                    <div class="col-12" id="{{$detail->id}}"
                                         style="border: black solid 2px;justify-content: center;display: flex;padding: 10px 0px 10px 0px;margin-top: 10px;">
                                        <!-- ues from add new details -->
                                        <input id="idDetails_{{$detail->id}}" type="text"
                                               name="idDetails_{{$detail->id}}"
                                               value="{{$detail->id}}" hidden>
                                        <div class="col-11">
                                            <a class="delete" style="cursor: pointer">
                                                <img src="/logo/deleteRed.png" width="20" height="20"
                                                     style="float: right">
                                                <input type="text" name="{{$detail->id}}"
                                                       value="{{$detail->id}}" hidden>
                                            </a>
                                            <div class="col-12">
                                                <a>INSTRUMENT:<input name="instrument_{{$detail->id}}" class="inputText"
                                                                     placeholder="INSTRUMENT"
                                                                     value="{{$detail->instrument}}"></a>
                                            </div>
                                            <div class="col-12">
                                                <a>EFFECT:</a>
                                                <div class="col-12">
                                                    @for($i=-4;$i<=4;$i++)
                                                        <label for="child"
                                                               style="border-left: 1px solid black;padding-left: 5px">{{$i}}</label>
                                                        @if($detail->effect==$i)
                                                            <input type="radio" id="{{$detail->id}}"
                                                                   name="effect_{{$detail->id}}"
                                                                   value="{{$i}}" checked>
                                                        @else
                                                            <input type="radio" id="{{$detail->id}}"
                                                                   name="effect_{{$detail->id}}"
                                                                   value="{{$i}}">
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <a>IMPORTANT:</a>
                                                @if($detail->important==1)
                                                    <a>YES: <input type="radio" id="important"
                                                                   name="important_{{$detail->id}}"
                                                                   value="1" checked></a>
                                                    <a>NO: <input type="radio" id="important"
                                                                  name="important_{{$detail->id}}"
                                                                  value="0"></a>
                                                @else
                                                    <a>YES: <input type="radio" id="important"
                                                                   name="important_{{$detail->id}}"
                                                                   value="1"></a>
                                                    <a>NO: <input type="radio" id="important"
                                                                  name="important_{{$detail->id}}"
                                                                  value="0" checked></a>
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <a>COMMENT: <input name="comment_{{$detail->id}}" class="inputText"
                                                                   placeholder="comment"
                                                                   value="{{$detail->comment}}"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-1" style="padding-top: 10px">
                            <button type="button" name="{{$new->id}}" class="addDetails"
                                    style="width: 30px;height: 30px;background-color: green;border: transparent;border-radius: 10px;cursor: cell;margin-right: 5px;color: white ">
                                +
                            </button>
                        </div>

                        <div class="col-12" style="display: flex;justify-content: center;padding-top: 20px">
                            <div class="col-3">
                                <input id="details{{$new->id}}" class="inputSubmit" type="button" value="EDIT">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endforeach
        </body>
        <script>

            $('#toggleText').click(function () {
                $('#myDiv').slideToggle(500); /* افکت کشویی پایین آمدن */
                var arrow = document.getElementById('arrow');
                arrow.classList.toggle('rotated'); // اضافه یا حذف کلاس برای چرخش فلش
            });

            //صدای بوق
            function beep() {
                var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");
                snd.play();
            }

            var conn = new ReconnectingWebSocket('ws://82.115.16.178:1020');

            $(document).ready(function () {
                $("body").on('click', '.inputSubmit', function (e) { // changed

                    console.log($(this).closest("form")[0][1].value);

                    var newsID = $(this).closest("form")[0][1].value


                    conn.onopen = function (e) {
                        console.log("Connection stablished");
                    }


                    var element = "#" + $(this)[0].id
                    $(this).closest("form").serialize()
                    $.ajax({
                        type: "POST",
                        url: "/admin/editNews",
                        data: $(this).closest("form").serialize(), // changed
                        success: function (data) {
                            beep()
                            //ارسال آی دی اخبار تغییر کرده برای کلاینت ها
                            conn.send(newsID);
                        }
                    });
                    return false; // avoid to execute the actual form submission.
                });
            });
            window.setTimeout(function () {
                $("textarea").height($("textarea")[0].scrollHeight);
            }, 1);

            $("textarea").keyup(function (e) {
                while ($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
                    $(this).height($(this).height() + 1);
                }
                ;
            });


            let page = 1;
            let scrolling = false;

            //create url for request other pages
            let instrumentsFilters = {!! json_encode($lastInstrumentsFilters) !!};
            let importantState = {!! json_encode($lastImportantState) !!};
            let searchText = {!! json_encode($searchText)!!};
            let urlFiltersAndPageNumber = '?important=' + importantState;

            for (let i = 0; i < instrumentsFilters.length; i++) {
                urlFiltersAndPageNumber += "&" + instrumentsFilters[i] + "=on";
            }

            urlFiltersAndPageNumber += "&page=" + page;
            urlFiltersAndPageNumber += "&searchText=" + searchText;

            $(window).scroll(function () {
                if ($(window).height() + $(document).scrollTop() + 100 >= $(document).height() && scrolling === false) {
                    scrolling = true;
                    $.ajax({
                        type: "GET",
                        url: "/admin/insertScrollNews/" + urlFiltersAndPageNumber,
                        success: function (data) {
                            page = page + 1;
                            //replace page number increased instead old page number
                            urlFiltersAndPageNumber = urlFiltersAndPageNumber.replace(/(\d+)(?=&[^&=]*$|$)/, page); // جایگزینی عدد انتهایی با رشته خالی
                            $("body").append(data);
                            scrolling = false;
                        },
                        error: function () {
                            scrolling = false;
                        }
                    });
                }
            });


            let count = @json($lastDetailsID).id + 1;
            console.log(count);
            $(document).ready(function () {
                $("body").on('click', '.addDetails', function () { // changed

                    //آی دی  خبر
                    let news_id = $(this)[0].name;
                    //برای پیدا کردن div مخصوص برای اضافه کردن بلوک جزئیات اخبار
                    let id = "#" + $(this)[0]["attributes"].name.value
                    console.log(id);

                    $.get("/admin/addDetailsForm/" + count, function (data, status) {
                        //اضافه کردن جزئیات خبر جدید به بلوک مربوطه
                        $(id).append(data);
                        $('#countCarTypeFild').val(count);
                        count++;
                        console.log(count);
                    });


                });
            });
            $(window).on("load", function () {
                $('#countCarTypeFild').val(1);
            });


            $(document).ready(function () {
                $("body").on('click', '.delete', function () { // changed
                    console.log(this.lastElementChild.name)
                    newsID = $(this).closest("form")[0][1].value
                    let detailsElementID = this.lastElementChild.name;
                    $.ajax({
                        type: "GET",
                        url: "/admin/deleteDetailsForm/" + detailsElementID,
                        success: function (data) {
                            document.getElementById(detailsElementID).remove();
                            //ارسال آی دی اخبار تغییر کرده برای کلاینت ها
                            conn.send(newsID);
                        }
                    });
                });
            });

            $(document).ready(function () {
                $("body").on('click', '.deleteNews', function () { // changed
                    let newsElementID = this.lastElementChild.name;
                    let newsElementNameID = "news_" + newsElementID;
                    console.log(newsElementNameID);
                    //console.log($(this).closest("form")[0])
                    $.ajax({
                        type: "GET",
                        url: "/admin/deleteNewsForm/" + newsElementID,
                        success: function (data) {
                            //ارسال آی دی اخبار تغییر کرده برای کلاینت ها
                            conn.send(newsElementID);
                            document.getElementById(newsElementNameID).remove();
                        }
                    });
                });
            });


        </script>
        @endsection


