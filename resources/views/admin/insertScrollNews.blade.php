@foreach($news as $new)
    <form method="post" name="enter">
        @csrf
        <div class="col-12" style="justify-content: center;display: flex;color: #ff0000">
            <input type="text" name="id" value="{{$new->id}}" hidden>
            <div class="col-6 blockNews">
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
                    <hr style="margin-top: 10px">
                    <div class="col-12" style="padding-top: 5px">
                        @foreach($details as $detail)
                            @if($detail->news_id==$new->id)
                                <!-- ues from add new details -->
                                <input id="countDetailsField" type="text" name="countDetailsField" value="1" hidden>

                                <div class="col-12"
                                     style="border: black solid 2px;justify-content: center;display: flex;padding: 10px 0px 10px 0px;margin-top: 10px">
                                    <div class="col-11">
                                        <div class="col-12">
                                            <a>INSTRUMENT:<input name="instrument_1" class="inputText"
                                                                 placeholder="INSTRUMENT"
                                                                 value="{{glueTags($detail->id)}}"></a>
                                        </div>
                                        <div class="col-12">
                                            <a>EFFECT:</a>
                                            <div class="col-12">
                                                @for($i=-4;$i<=4;$i++)
                                                    <label for="child">{{$i}}</label>
                                                    @if($detail->effect==$i)
                                                        <input type="radio" id="{{$detail->id}}"
                                                               name="effect_{{$loop->index}}"
                                                               value="{{$i}}" checked>
                                                    @else
                                                        <input type="radio" id="{{$detail->id}}"
                                                               name="effect_{{$loop->index}}"
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
                                            <a>COMMENT: <input name="comment_1" class="inputText"
                                                               placeholder="comment"
                                                               value="{{$detail->comment}}"></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-1" style="padding-top: 10px">
                        <button type="button" name="details{{$new->id}}" class="addDetails"
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
