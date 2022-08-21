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
                    <li class="breadcrumb-item" aria-current="page">Môn học</li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa Môn học</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">CHỈNH SỬA MÔN HỌC</h4>
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
    @foreach ($editmonhoc as $key => $item)
        <form action="{{URL::to('/action_editmonhoc'.'/'.$item -> mahp)}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">Mã môn học</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" readonly value="{{$item -> mahp}}" type="text" name="mamonhoc" placeholder="Mã môn học...">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">Tên môn học</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" value="{{$item -> tenhp}}" name="tenmonhoc" placeholder="Tên môn học" type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">tín chỉ</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" value="{{$item -> tinchi}}" name="tinchi" placeholder="....." type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">tín chỉ lý thuyết</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" value="{{$item -> tinchilt}}" name="tinchilt" placeholder="....." type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">số tiết lý thuyết</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" value="{{$item -> sotietlt}}" name="sotietlt" placeholder="....." type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">tín chỉ thực hành</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" value="{{$item -> tinchith}}" name="tinchith" placeholder="....." type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">số tiết thực hành</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" value="{{$item -> sotietth}}" name="sotietth" placeholder="....." type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Ghi chú</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" value="{{$item -> sotietth}}" name="ghichu" placeholder="....." type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Hiển thị</label>
                <div class="col-sm-12 col-md-10">
                    @if ($item -> status == 1)
                        <input type="checkbox" checked name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                    @else
                        <input type="checkbox" name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                    @endif
                </div>
            </div>
            <button type="submit" name="capnhat" class="btn btn-primary">Cập nhật</button>
        </form>
    @endforeach
</div>

@endsection