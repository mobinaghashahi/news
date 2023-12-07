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
                    <div class="col-12">
                        <a>INSTRUMENT:<input name="instrument" class="inputText"
                                             placeholder="INSTRUMENT" value="{{glueTags($new->id)}}"></a>
                    </div>
                    <hr style="margin-top: 10px">
                    <div class="col-12">
                        <a>EFFECT:</a>
                        <div class="col-12">
                            @for($i=-4;$i<=4;$i++)
                                <label for="child">{{$i}}</label>
                                @if($new->effect==$i)
                                    <input type="radio" id="{{$new->id}}" name="effect" value="{{$i}}" checked>
                                @else
                                    <input type="radio" id="{{$new->id}}" name="effect" value="{{$i}}">
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div class="col-12">
                        @if($new->important==1)
                            <a>IMPORTANT: <input type="checkbox" id="important" name="important" value="1" checked></a>
                        @else
                            <a>IMPORTANT: <input type="checkbox" id="important" name="important"></a>
                        @endif
                    </div>
                    <div class="col-12">
                        <a>COMMENT: <input name="comment"  class="inputText"
                                           placeholder="comment" value="{{$new->comment}}"></a>
                    </div>
                    <div class="col-12" style="display: flex;justify-content: center;padding-top: 20px">
                        <div class="col-3">
                            <input id="button{{$new->id}}" class="inputSubmit" type="button" value="EDIT">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endforeach
