@extends('admin.menu')
@section('content')
    <div class="main">
        <div class="col-12" style="text-align: center;padding-top: 15px;">
            <a style="background-color: #363636;padding: 10px;border-radius: 5px;color: white">ویرایش برندها</a>
        </div>
        <div class="blockOfInputs">
            <div class="col-12" style="padding-top: 50px;display: flex;justify-content: center">
                <div class="col-11">
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
                    <table>
                        <tr>
                            <th class="editeTables" style="width: 50px">ردیف</th>
                            <th class="editeTables">نام</th>
                            <th class="editeTables">نام کاربری</th>
                            <th  class="editeTables">نوع کاربر</th>
                            <th  class="editeTables">عملیات</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td class="editeTables">{{$loop->index+1}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->userName}}</td>
                                <td>{{$user->type}}</td>
                                <td>
                                    <div class="col-6">
                                        <a href="/admin/deleteUser/{{$user->id}}"> <img src="/logo/deleteRed.png" width="15" height="15"></a>
                                    </div>
                                    <div class="col-6">
                                        <a href="/admin/editUser/{{$user->id}}"> <img src="/logo/pen.png" width="15" height="15"></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
