@extends('admin.menu')
@section('content')
    <div class="main">
        <div class="col-12" style="text-align: center;padding-top: 15px;">
            <a style="background-color: #363636;padding: 10px;border-radius: 5px;color: white">افزودن کاربر جدید</a>
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

            <form method="post" name="enter" id="form" enctype="multipart/form-data" action="/admin/addUser">
                @csrf
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="name" style="text-align: center" class="inputText" placeholder="Name">
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="userName" style="text-align: center" class="inputText" placeholder="User Name">
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="password" style="text-align: center" class="inputText" placeholder="Password">
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-4" style="text-align: center">
                        <label>User Type</label>
                        <select class="inputText" style="background-color: white;text-align: center" name="type" id="userType">
                                <option value="user">User</option>
                                <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="col-12" style="padding-top: 10px;display: flex;justify-content: center">
                    <div class="col-3">
                        <input class="inputSubmit" type="submit" value="افزودن">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
