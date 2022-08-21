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
                    <li class="breadcrumb-item" aria-current="page">Lớp</li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa Lớp</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">CHỈNH SỬA LỚP</h4>
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
    @foreach ($editlop as $key => $item)
        <form action="{{URL::to('/action_editlop'.'/'.$item -> malop)}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">Mã ngành</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" readonly value="{{$item -> malop}}" type="text" name="malop" placeholder="Mã ngành...">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 col-md-2 col-form-label">Tên ngành</label>
                <div class="col-sm-6 col-md-10">
                    <input class="form-control" value="{{$item -> tenlop}}" name="tenlop" placeholder="Tên ngành" type="text">
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