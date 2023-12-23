@extends('layout.master')

@section('content')
    <div class="col-12" style="display: flex;justify-content: center;">
        <div class="col-3 loginForm" style="padding: 50px 0px 50px 0px">
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
            <form method="post" name="enter" action="/login">
                @csrf
                <div class="col-12 divLabelInput">
                    <a style="color: white">User Name</a>
                </div>
                <div class="col-12 divInputText">
                    <input name="userName" type="text" class="inputText">
                </div>

                <div class="col-12 divLabelInput">
                    <a style="color: white">Password</a>
                </div>
                <div class="col-12 divInputText">
                    <input name="password" type="password" class="inputText">
                </div>

                <div class="col-12 divInputSubmit">
                    <input name="enter" class="inputSubmit" type="submit" value="Login">
                </div>

            </form>
        </div>
    </div>
@endsection
