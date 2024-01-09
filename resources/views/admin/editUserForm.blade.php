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

            <form method="post" name="enter" id="form" enctype="multipart/form-data" action="/admin/editUser">
                @csrf
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="name" style="text-align: center" class="inputText" placeholder="Name"
                               value="{{$user[0]->name}}">
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="userName" style="text-align: center" class="inputText" placeholder="User Name"
                               value="{{$user[0]->userName}}">
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-5">
                        <input name="password" style="text-align: center" class="inputText" placeholder="Password">
                        <a style="color: red;font-size: 10px">
                            در صورتی که مایل به تغییر رمز عبور نیستید، این فیلد را خالی بگذارید.
                        </a>
                    </div>
                </div>
                <div class="col-6 titleTextInput" style="display: flex;justify-content: center">
                    <div class="col-4" style="text-align: center">
                        <label>User Type</label>
                        <select class="inputText" style="background-color: white;text-align: center" name="type"
                                id="userType">
                            @if($user[0]->type=="admin")
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            @else
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            @endif
                        </select>
                    </div>
                </div>
                <input hidden name="userID" style="text-align: center" class="inputText"
                       value="{{$user[0]->id}}">
                <div class="col-12" style="padding-top: 10px;display: flex;justify-content: center">
                    <div class="col-3">
                        <input class="inputSubmit" type="submit" value="ویرایش">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
