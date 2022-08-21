@extends('layout')
@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Quản lý</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Quản lý</a></li>
                    <li class="breadcrumb-item" aria-current="page">Chương trình đào tạo</li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm Chương trình đào tạo</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">THÊM CHƯƠNG TRÌNH ĐÀO TẠO</h4>
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
    <form action="{{URL::to('/savectdt')}}" method="POST">
        {{ csrf_field() }}

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Khóa chương trình đào tạo</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" name="khoactdt" placeholder="Khóa chương trình đào tạo...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã hệ</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="mahe" id="mahe" class="form-select">
                            <option selected disabled>------Select------</option>
                            @foreach ($listhe as $key => $he)
                                <option value="{{$he -> mahe}}">{{$he -> mahe}} - {{$he -> he}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Tự chọn</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" name="tuchon" placeholder="tự chọn...">
                    </div>
                </div>
            </div>

            {{-- col  2 --}}
            <div class="col">

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã học phần</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="mahp" id="mahp" class="form-select">
                            <option selected disabled>------Select------</option>
                            @foreach ($listmonhoc as $key => $item)
                                <option value="{{$item -> mahp}}">{{$item -> mahp}} - {{$item -> tenhp}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã ngành</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="manganh" id="manganh" class="form-select">
                            <option selected disabled>------Select------</option>
                            @foreach ($listnganh as $key => $item)
                                <option value="{{$item -> manganh}}">{{$item -> manganh}} - {{$item -> tennganh}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Số tín chỉ tự chọn</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" name="sotinchitc" placeholder="tín chỉ tự chọn..." >
                    </div>
                </div>

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