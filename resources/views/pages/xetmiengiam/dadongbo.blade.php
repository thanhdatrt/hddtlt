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
                        <li class="breadcrumb-item active" aria-current="page">Đã đồng bộ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">DANH SÁCH SINH VIÊN ĐÃ ĐỒNG BỘ</h4>
            <?php
                $message = Session::get('message');
                if($message) {
                    echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
                    Session::put('message', null);
                }
            ?>
            @if (isset($sinhvien))
                <table style="margin-top: 20px" class="tablemonhoc data-table table stripe hover warp">
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
                            <th class="datatable-nosort">Đồng bộ</th>
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
                                    <a class="btn btn-info justify-content-center" href="{{URL::to('/huydongbo/'.$item -> masv.'/'.$item -> manganh)}}">Hủy</a>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 

@endsection