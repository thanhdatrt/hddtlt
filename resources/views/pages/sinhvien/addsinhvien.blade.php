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
                    <li class="breadcrumb-item active" aria-current="page">Thêm Sinh viên</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">THÊM SINH VIÊN</h4>
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
    <form action="{{URL::to('/savesinhvien')}}" method="POST">
        {{ csrf_field() }}

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã sinh viên</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" name="masv" placeholder="Mã sinh viên...">
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
                    <label class="col-sm-6 col-md-12 col-form-label">Họ tên sinh viên</label>
                    <div class="col-sm-6 col-md-12">
                        <input class="form-control" type="text" name="hoten" placeholder="họ tên sinh viên...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã lớp</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="malop" id="malop" class="form-select">
                            <option selected disabled>------Select------</option>
                            @foreach ($listlop as $key => $item)
                                <option value="{{$item -> malop}}">{{$item -> malop}} - {{$item -> tenlop}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Khóa chương trình đào tạo</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="khoactdt" id="khoactdt" class="form-select">
                            <option selected disabled>------Select------</option>
                            @foreach ($listctdt as $key => $ctdt)
                                <option value="{{$ctdt -> khoactdt}}">{{$ctdt -> khoactdt}}</option>
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
                        <input class="form-control" type="text" name="mahs" placeholder="Mã hồ sơ...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã hình thức đào tạo</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="mahtdt" id="mahtdt" class="form-select">
                            <option selected disabled>------Select------</option>
                               
                            @foreach ($listhtdt as $key => $item)
                                <option value="{{$item -> mahtdt}}">{{$item -> mahtdt}} - {{$item -> tenhtdt}}</option>
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
                            <option selected disabled>------Select------</option>
                            @foreach ($listnganh as $key => $item)
                                <option value="{{$item -> manganh}}">{{$item -> manganh}} - {{$item -> tennganh}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 col-md-12 col-form-label">Mã khóa</label>
                    <div class="col-sm-6 col-md-12">
                        <select class="form-control" name="makhoa" id="makhoa" class="form-select">
                            <option selected disabled>------Select------</option>
                            @foreach ($listkhoa as $key => $item)
                                <option value="{{$item -> makhoa}}">{{$item -> makhoa}} - {{$item -> tenkhoa}}</option>
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
                <input type="checkbox" checked name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
            </div>
        </div>
        <button type="submit" name="them" class="btn btn-primary">Thêm</button>

    </form>
</div>
@endsection