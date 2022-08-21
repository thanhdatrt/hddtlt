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
                    <li class="breadcrumb-item" aria-current="page">Sinh viên</li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa Sinh viên</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">SỬA SINH VIÊN</h4>
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
    @foreach ($editsinhvien as $key => $item)
    <form action="{{URL::to('/action_editsinhvien/'.$item -> masv)}}" method="POST">
        {{ csrf_field() }}

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã sinh viên</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" value="{{ $item -> masv}}"name="masv" placeholder="Mã sinh viên...">
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
                    <label class="col-sm-6 col-md-12 col-form-label">Họ tên sinh viên</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" value="{{$item -> hoten}}"name="hoten" placeholder="họ tên sinh viên...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã lớp</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="malop" id="malop" class="form-select">
                            @foreach ($listlop as $key => $lop)
                                @if ($lop -> malop == $item -> malop)
                                <option selected value="{{$lop -> malop}}">{{$lop -> malop}} - {{$lop -> tenlop}}</option>
                                @else
                                <option value="{{$lop -> malop}}">{{$lop -> malop}} - {{$lop -> tenlop}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Khóa chương trình đào tạo</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="khoactdt" id="khoactdt" class="form-select">
                            @foreach ($listctdt as $key => $khoactdt)
                                @if ($khoactdt -> khoactdt == $item -> khoactdt)
                                <option selected value="{{$khoactdt -> khoactdt}}">{{$khoactdt -> khoactdt}}</option>
                                @else
                                <option value="{{$khoactdt -> khoactdt}}">{{$khoactdt -> khoactdt}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                

            </div>

            {{-- col  2 --}}
            <div class="col">
                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã hồ sơ</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" value="{{$item -> mahs}}"name="mahs" placeholder="Mã hồ sơ...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã hình thức đào tạo</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="mahtdt" id="mahtdt" class="form-select">
                            @foreach ($listhtdt as $key => $htdt)
                                @if ($htdt -> mahtdt == $item -> mahtdt)
                                <option selected value="{{$htdt -> mahtdt}}">{{$htdt -> mahtdt}} - {{$htdt -> tenhtdt}}</option>
                                @else
                                <option value="{{$htdt -> mahtdt}}">{{$htdt -> mahtdt}} - {{$htdt -> tenhtdt}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Ngày sinh</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="date" min="1950-01-01" max="2010-12-31" name="ngaysinh" placeholder="họ tên sinh viên...">
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
                    <label class="col-sm-6 col-md-12 col-form-label">Mã khóa</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="makhoa" id="makhoa" class="form-select">
                            @foreach ($listkhoa as $key => $khoa)
                                @if ($khoa -> makhoa == $item -> makhoa)
                                <option selected value="{{$khoa -> makhoa}}">{{$khoa -> makhoa}} - {{$khoa -> tenkhoa}}</option>
                                @else
                                <option value="{{$khoa -> makhoa}}">{{$khoa -> makhoa}} - {{$khoa -> tenkhoa}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-6 col-md-12 col-form-label">Ghi chú</label>
            <div class="col-sm-6 col-md-12">
                <input class="form-control" type="text" name="ghichu" placeholder="Ghi chú...">
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