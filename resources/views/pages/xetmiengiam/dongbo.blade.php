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
                        <li class="breadcrumb-item" aria-current="page">Xét miễn giảm</li>
                        <li class="breadcrumb-item active" aria-current="page">Đồng bộ dữ liệu sinh viên - chương trình đào tạo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">LỌC DỮ LIỆU</h4>
            <?php
                $message = Session::get('message');
                if($message) {
                    echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
                    Session::put('message', null);
                }
            ?>
            <form action="{{URL::to('/dongbo')}}" method="GET">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="col-sm-6 col-md-12 col-form-label">Mã hệ</label>
                            <div class="col-sm-6 col-md-12">
                                <select class="form-control" name="mahe" id="mahe" class="form-select">
                                    <option selected disabled>------Select------</option>
                                    @if (isset($listhe))    
                                    @foreach ($listhe as $key => $he)
                                    @if (isset($mahe))
                                        @if ($he -> mahe == $mahe)
                                            <option selected value="{{$he -> mahe}}">{{$he -> mahe}} - {{$he -> he}}</option>
                                        @else
                                            <option value="{{$he -> mahe}}">{{$he -> mahe}} - {{$he -> he}}</option>
                                        @endif
                                    @else
                                        <option value="{{$he -> mahe}}">{{$he -> mahe}} - {{$he -> he}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 col-md-12 col-form-label">Mã khóa</label>
                            <div class="col-sm-6 col-md-12">
                                <select class="form-control" name="makhoa" id="makhoa" class="form-select">
                                    <option selected disabled>------Select------</option>
                                    @if (isset($listkhoa))    
                                    @foreach ($listkhoa as $key => $khoa)
                                    @if (isset($mahe))
                                        @if ($khoa -> makhoa == $makhoa)
                                            <option selected value="{{$khoa -> makhoa}}">{{$khoa -> makhoa}} - {{$khoa -> tenkhoa}}</option>
                                        @else
                                            <option value="{{$khoa -> makhoa}}">{{$khoa -> makhoa}} - {{$khoa -> tenkhoa}}</option>
                                        @endif
                                    @else
                                        <option value="{{$khoa -> makhoa}}">{{$khoa -> makhoa}} - {{$khoa -> tenkhoa}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="col-sm-6 col-md-12 col-form-label">Mã ngành</label>
                            <div class="col-sm-6 col-md-12">
                                <select class="form-control" name="manganh" id="manganh" class="form-select">
                                    <option selected disabled>------Select------</option>
                                    @if (isset($listnganh))    
                                    @foreach ($listnganh as $key => $nganh)
                                    @if (isset($mahe))
                                        @if ($nganh -> manganh == $manganh)
                                            <option selected value="{{$nganh -> manganh}}">{{$nganh -> manganh}} - {{$nganh -> tennganh}}</option>
                                        @else
                                            <option value="{{$nganh -> manganh}}">{{$nganh -> manganh}} - {{$nganh -> tennganh}}</option>
                                        @endif
                                    @else
                                        <option value="{{$nganh -> manganh}}">{{$nganh -> manganh}} - {{$nganh -> tennganh}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 col-md-12 col-form-label">khóa CTĐT</label>
                            <div class="col-sm-6 col-md-12">
                                <select class="form-control" name="khoactdt" id="khoactdt" class="form-select">
                                    <option selected disabled>------Select------</option>
                                    @if (isset($listkhoactdt))
                                    @foreach ($listkhoactdt as $key => $ctdt)
                                    @if (isset($mahe))
                                        @if ($ctdt == $khoactdt)
                                            <option selected value="{{$ctdt}}">{{$ctdt}}</option>
                                        @else
                                            <option value="{{$ctdt}}">{{$ctdt}}</option>
                                        @endif
                                    @else
                                        <option value="{{$ctdt}}">{{$ctdt}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 align-self-center">
                        <div class="form-group">
                            <button type="submit" style="margin-top:40px" class="btn btn-primary mb-2"><i class="fa-solid fa-filter"></i>
                                Lọc
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">DANH SÁCH SINH VIÊN</h4>
            <?php
                $message = Session::get('message');
                if($message) {
                    echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
                    Session::put('message', null);
                }
            ?>
            @if (isset($sinhvien))
                <table class="tablemonhoc data-table table stripe hover warp">
                    <thead>
                        <tr>
                            <th>Masv</th>
                            <th class="datatable-nosort">Mahs</th>
                            <th class="datatable-nosort">Họ tên</th>
                            <th class="datatable-nosort">Ngày sinh</th>
                            <th class="datatable-nosort">Mã hệ</th>
                            <th class="datatable-nosort">Mã htdt</th>
                            <th class="datatable-nosort">Mã lớp</th>
                            <th class="datatable-nosort">Mã khóa</th>
                            <th class="datatable-nosort">Mã Ngành</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sinhvien) > 0)    
                            @foreach ($sinhvien as $item)
                            <tr>   
                                <td>{{$item -> masv}}</td>
                                <td>{{$item -> mahs}}</td>
                                <td>{{$item -> hoten}}</td>
                                <td>{{$item -> ngaysinh}}</td>
                                <td>{{$item -> mahe}}</td>
                                <td>{{$item -> mahtdt}}</td>
                                <td>{{$item -> malop}}</td>
                                <td>{{$item -> makhoa}}</td>
                                <td>{{$item -> manganh}}</td>
                                <td>
                                    <a class="btn btn-info justify-content-center" href="{{URL::to('/savesinhvien-ctdt/'.$item -> masv.'/'.$item -> manganh.'/'.$item -> mahe.'/'.$item -> khoactdt)}}"><i class="fa-solid fa-bookmark"></i> Đồng bộ</a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <td class="text-center" colspan="10">không có dữ liệu</td>
                        @endif
                    </tbody>
                </table>
            @else
                <p class="text-center">không có dữ liệu sinh viên</p>
            @endif
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">CHƯƠNG TRÌNH ĐÀO TẠO</h4>
            @if (isset($chuongtrinhdt))
                <table class="tablemonhoc data-table table stripe hover warp">
                    <thead>
                        <tr>
                            <th>stt</th>
                            <th class="datatable-nosort">Mã ngành</th>
                            <th class="datatable-nosort">Mã hệ</th>
                            <th class="datatable-nosort">Mhóa ctdt</th>
                            <th class="datatable-nosort">Mã hp</th>
                            <th class="datatable-nosort">Tự chọn</th>
                            <th class="datatable-nosort">Số tín chỉ tc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($chuongtrinhdt) > 0)
                            @foreach ($chuongtrinhdt as $ct)
                            <tr>
                                <td>{{$ct -> stt}}</td>
                                <td>{{$ct -> manganh}}</td>
                                <td>{{$ct -> mahe}}</td>
                                <td>{{$ct -> khoactdt}}</td>
                                <td>{{$ct -> mahp}}</td>
                                <td>{{$ct -> tuchon}}</td>
                                <td>{{$ct -> sotinchitc}}</td>
                            </tr>
                            @endforeach
                        @else
                            <td class="text-center" colspan="7">không có dữ liệu</td>
                        @endif
                        
                    </tbody>
                </table>
            @else
                <p class="text-center">không có dữ liệu sinh viên</p>
            @endif
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 

@endsection