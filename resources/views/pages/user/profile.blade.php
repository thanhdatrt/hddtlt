@extends('layout')
@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Profile</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <?php
                $message = Session::get('message');
                if($message) {
                    echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
                    Session::put('message', null);
                }
            ?>
            @foreach ($user as $item)
                <div class="profile-photo">
                    <img src="{{$item -> avatar}}" alt="" class="avatar-photo">
                </div>
                <h5 class="text-center h5 mb-0">{{$item -> name}}</h5>
                <div class="profile-info">
                    <h5 class="mb-20 h5 text-blue">Thông tin liên hệ</h5>
                    <form action="{{URL::to('/capnhattt')}}" method="post">
                        @csrf
                        <ul>
                            <li>
                                <span>Địa chỉ Email</span>
                                {{$item -> email}}
                            </li>
                            <li>
                                <span>Họ Tên</span>
                                <input type="text" class="form-control" name="hoten" value="{{$item -> name}}">
                            </li>
                            <li>
                                <span>Số điện thoại</span>
                                <input type="text" class="form-control" name="phone" value="{{$item -> phone}}">
                            </li>
                            <li>
                                <span>Avatar</span>
                                <input type="text" class="form-control" name="avatar" value="{{$item -> avatar}}">
                            </li>
                        </ul>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
                <div class="profile-social">
                    <h5 class="mb-20 h5 text-blue">Đổi mật khẩu</h5>
                    <form action="{{URL::to('/doimatkhau')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <span>Mật khẩu cũ</span>
                            <input type="password" class="form-control" name="mkcu">
                        </div>
                        <div class="form-group">
                            <span>Mật khẩu mới</span>
                            <input type="password" class="form-control" name="mkmoi">
                        </div>
                        <div class="form-group">
                            <span>Nhập lại mật khẩu</span>
                            <input type="password" class="form-control" name="mkmoi1">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Thay đổi</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>


@endsection