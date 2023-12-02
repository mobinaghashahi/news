@extends('layout.master')
@section('content')


@foreach($news as $new)
<div class="col-12" style="justify-content: center;display: flex">
    <div class="col-6 blockNews">
        <div class="col-12">
            <pre>{{$new->text}}</pre>
        </div>
        <div class="bottomBlockNews">
            <div class="col-12">
                <a>TITLE: {{$new->title}}</a>
            </div>
            <div class="col-12">
                <a>DATE: {{$new->created_at}}</a>
            </div>
            <div class="col-12">
                <a>INSTRUMENT:</a>
            </div>
            <div class="col-12">
                <a>EFFECT: {{$new->effect}}</a>
            </div>
            <div class="col-12">
                <a>IMPORTANT: {{$new->important}}</a>
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


