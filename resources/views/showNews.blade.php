@extends('layout.master')
@section('content')


@foreach($news as $new)
<div class="col-12" style="justify-content: center;display: flex;color: #ff0000">
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
            <div class="col-12">
                <a>INSTRUMENT:{{$tags[$new->id]}}</a>
            </div>
            <div class="col-12">
                <a>EFFECT: <span style="color: {{effectColors()[$new->effect]}}">{{$new->effect}}</span></a>
            </div>
            <div class="col-12">
                @if($new->important==1)
                    <a>IMPORTANT: YES</a>
                @else
                    <a>IMPORTANT: NO</a>
                @endif
            </div>
            <div class="col-12">
                <a>COMMENT: {{$new->comment}}</a>
            </div>
        </div>
    </div>
</div>
@endforeach

</body>
@endsection


