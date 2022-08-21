@extends('layout')
@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Quản lý</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Quản lý</a></li>
                    <li class="breadcrumb-item" aria-current="page">Hình thức đào tạo</li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm hình thức đào tạo</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">THÊM HÌNH THỨC ĐÀO TẠO</h4>
        </div>
    </div>
    </br>
    <?php
        $message = Session::get('message');
        if($message) {
            echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
            Session::put('message', null);
        }
    ?>
    <form action="{{URL::to('/savehtdt')}}" method="POST">
        {{ csrf_field() }}
        <div class="form-group row">
            <label class="col-sm-6 col-md-2 col-form-label">Mã hình thức đào tạo</label>
            <div class="col-sm-6 col-md-10">
                <input class="form-control" type="text" name="mahtdt" placeholder="Mã hình thức đào tạo...">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-6 col-md-2 col-form-label">Tên hình thức đào tạo</label>
            <div class="col-sm-6 col-md-10">
                <input class="form-control" name="tenhtdt" placeholder="Tên hình thức đào tạo..." type="text">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Hiển thị</label>
            <div class="col-sm-12 col-md-10">
                <input type="checkbox" checked name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
            </div>
        </div>
        <button type="submit" name="them" class="btn btn-primary">Thêm</button>
    </form>
</div>
@endsection