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
