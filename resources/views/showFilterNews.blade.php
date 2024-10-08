@extends('layout.master')
@section('content')
    @include('filterNewsForm',["url" => "/filter"])
    <div class="col-12" style="display: flex;justify-content: center;padding: 10px 0px 0px 0px">
        <div class="col-6" style="background-color: #939393;padding: 10px;border-radius: 10px">
            <div class="col-12">
                <div style="float: left;margin: 10px 5px;padding-bottom: 10px">
                    <a style="color:white;">Filters:</a>
                </div>
                @foreach($lastInstrumentsFilters as $instrument)
                    <div style="float: left;margin: 10px 5px;padding-bottom: 10px">
                        <a style="background-color: white;padding: 5px;border-radius: 10px">
                            #{{$instrument}}
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="col-12">
                <div style="float: left;margin: 10px 5px;width: 15%;padding-bottom: 10px">
                    <a style="background-color: white;padding: 5px;border-radius: 10px;">
                        Important&nbsp;state&nbsp;:&nbsp;{{$lastImportantState}}
                    </a>
                </div>
            </div>
            <div class="col-12" style="padding-top: 20px;margin-bottom: 10px">
                <a style="background-color: #525252;padding: 5px;border-radius: 10px;cursor: pointer;text-decoration: none;color: white"
                   href="/">Delete Filters</a>
            </div>
        </div>
    </div>
    <div id="news">
        @foreach($news as $new)
            <div class="col-12" id="{{$new->id}}" style="justify-content: center;display: flex;">
                <div class="col-6 blockNews">
                    <div class="col-12">
                        <pre class="newsShowBlock">{{$new->text}}</pre>
                    </div>
                    <div class="bottomBlockNews">
                        <div class="col-12">
                            <a>TITLE: {{$new->title}}</a>
                        </div>
                        <div class="col-12">
                            <a>DATE: {{$new->created_at}}</a>
                        </div>
                        @foreach($details as $detail)
                            @if($detail->news_id==$new->id)
                                <hr>
                                <div class="col-12" style="display:flex;justify-content: center">
                                    <div class="col-11">
                                        <div class="col-12">
                                            <a>INSTRUMENT:{{$detail->instrument}}</a>
                                        </div>
                                        <div class="col-12">
                                            <a>EFFECT: <span
                                                    style="color: {{effectColors()[$detail->effect]}}">{{$detail->effect}}</span></a>
                                        </div>
                                        <div class="col-12">
                                            @if($detail->important==1)
                                                <a>IMPORTANT: YES</a>
                                            @else
                                                <a>IMPORTANT: NO</a>
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <a>COMMENT: {{$detail->comment}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        //باز شدن کشوی فیلترها
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

        //get hash for check news change when connection is faild
        let hashNews = {!! json_encode($newsHash) !!};
        let page = 1;
        let scrolling = false;

        //create url for request other pages
        let instrumentsFilters = {!! json_encode($lastInstrumentsFilters) !!};
        let importantState = {!! json_encode($lastImportantState) !!};
        let urlFiltersAndPageNumber = '?important=' + importantState;
        for (let i = 0; i < instrumentsFilters.length; i++) {
            urlFiltersAndPageNumber += "&" + instrumentsFilters[i] + "=on";
        }
        urlFiltersAndPageNumber += "&page=" + page;

        $(window).scroll(function () {
            //if scroll arrive to end page
            if ($(window).height() + $(document).scrollTop() + 100 >= $(document).height() && scrolling === false) {
                //get new news blocks
                scrolling = true;
                $.ajax({
                    type: "GET",
                    url: "/insertScrollNewsWhitFilters/" + urlFiltersAndPageNumber,
                    success: function (data) {
                        page = page + 1;
                        //replace page number increased instead old page number
                        urlFiltersAndPageNumber = urlFiltersAndPageNumber.replace(/(\d+)(?=&[^&=]*$|$)/, page); // جایگزینی عدد انتهایی با رشته خالی
                        $("#news").append(data);
                        scrolling = false;
                    },
                    error: function () {
                        scrolling = false;
                    }
                });
            }
        });


        $(document).ready(function () {
            var conn = new ReconnectingWebSocket('ws://82.115.16.178:1020');
            conn.onopen = function (e) {
                console.log("Connection stablished");
            }
            conn.onmessage = function (e) {
                message = e.data;
                console.log(message)
                if (message === "new") {
                    $.ajax({
                        type: "GET",
                        url: "/addNewNewsBlock",
                        success: function (data) {
                            console.log("new NEWS")
                            $("#news").prepend(data);
                        }
                    });
                } else {
                    var newsID = e.data
                    console.log("newsID edite:" + newsID)
                    var divID = "#" + newsID;
                    $.ajax({
                        type: "GET",
                        url: "/singleBlockNews/" + newsID,
                        success: function (data) {
                            $(divID).replaceWith(data);
                        }
                    });
                }

            }
        });
    </script>
    </body>
@endsection


