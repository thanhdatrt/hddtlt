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
                    <li class="breadcrumb-item" aria-current="page">Chương tình đào tạo</li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa Chương trình đào tạo</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">SỬA CHƯƠNG TRÌNH ĐÀO TẠO</h4>
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
    @foreach ($editctdt as $key => $item)
    <form action="{{URL::to('/editctdt')}}" method="POST">
        {{ csrf_field() }}

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Khóa chương trình đào tạo</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" value="{{ $item -> khoactdt}}"name="khoactdt" placeholder="khóa chương trình đào tạo...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã hệ</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="mahe" id="mahe" class="form-select">
                            @foreach ($listhe as $key => $he)
                                @if ($he -> mahe == $item -> mahe)
                                <option selected value="{{$he -> mahe}}">{{$he -> mahe}} - {{$he -> he}}</option>    
                                @else
                                <option value="{{$he -> mahe}}">{{$he -> mahe}} - {{$he -> he}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Tự chọn</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" value="{{$item -> tuchon}}"name="tuchon" placeholder="tự chọn...">
                    </div>
                </div>

            </div>

            {{-- col  2 --}}
            <div class="col">
                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã học phần</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="mahp" id="mahp" class="form-select">
                            @foreach ($listmonhoc as $key => $monhoc)
                                @if ($monhoc -> mahp == $item -> mahp)
                                <option selected value="{{$monhoc -> mahp}}">{{$monhoc -> mahp}} - {{$monhoc -> tenhp}}</option>
                                @else
                                <option value="{{$monhoc -> mahp}}">{{$monhoc -> mahp}} - {{$monhoc -> tenhp}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã ngành</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="manganh" id="manganh" class="form-select">
                            @foreach ($listnganh as $key => $nganh)
                                @if ($nganh -> manganh == $item -> manganh)
                                <option selected value="{{$nganh -> manganh}}">{{$nganh -> manganh}} - {{$nganh -> tennganh}}</option>
                                @else
                                <option value="{{$nganh -> manganh}}">{{$nganh -> manganh}} - {{$nganh -> tennganh}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Số tín chỉ tự chọn</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" value="{{$item -> sotinchitc}}" name="sotinchitc" placeholder="">
                    </div>
                </div>

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
        <button type="submit" name="them" class="btn btn-primary">Cập nhật</button>
    </form>
    @endforeach
</div>
@endsection