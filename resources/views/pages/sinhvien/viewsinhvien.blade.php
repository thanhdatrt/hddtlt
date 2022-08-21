@extends('layout')
@section('content')

<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

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
                        <li class="breadcrumb-item active" aria-current="page">Danh sách Sinh viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">DANH SÁCH SINH VIÊN</h4>

            <div class="pull-left">
                <form class="form-inline" action="{{URL::to('/import_sinhvien')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <input name="filesinhvien" type="file" class=" btn height-auto">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-plus"></i> import excel</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="pull-right">
                <div class="input-group">
                    <form class="form-inline" action="{{URL::to('/viewsinhvien')}}" method="GET">
                        <div class="form-group mx-sm-3 mb-2">
                          <input type="search" name="keyword" class="form-control" id="example-search-input" placeholder="mã sv, họ tên sv, mã lớp...">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <a class="btn mb-2"href="{{URL::to('/viewsinhvien')}}"><i class="fa-solid fa-arrows-rotate"></i></a>
                    </form>
                </div>


            </div>
        </div>

        <div class="pb-20">
            @if (isset($viewsinhvien))
                
            <table id="tablesinhvien" class="tablesinhvien data-table table stripe hover warp">
                <thead>
                    <tr>
                        <th class="datatable-nosort">Mã sinh viên</th>
                        <th class="datatable-nosort">Mã hồ sơ</th>
                        <th class="datatable-nosort">Mã hệ</th>
                        <th class="datatable-nosort">Mã Htđt</th>
                        <th class="datatable-nosort">Họ tên</th>
                        <th class="datatable-nosort">Ngày sinh</th>
                        <th class="datatable-nosort">Mã lớp</th>
                        <th class="datatable-nosort">Mã ngành</th>
                        <th class="datatable-nosort">Ghi chú</th>
                        <th class="datatable-nosort">Hiển thị</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($viewsinhvien) > 0)
                    @foreach ($viewsinhvien as $key => $item)    
                        <tr>
                            <td>{{$item -> masv}}</td>
                            <td>{{$item -> mahs}}</td>
                            <td>{{$item -> mahe}}</td>
                            <td>{{$item -> mahtdt}}</td>
                            <td>{{$item -> hoten}}</td>
                            <td>{{$item -> ngaysinh}}</td>
                            <td>{{$item -> malop}}</td>
                            <td>{{$item -> manganh}}</td>
                            <td>{{$item -> ghichu}}</td>
                            <td>
                                @if ($item -> status == 1)
                                    <a href="{{URL::to('/hiden_sinhvien'.'/'.$item -> masv)}}">
                                        <input type="checkbox" checked name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                                    </a>
                                @else
                                    <a href="{{URL::to('/show_sinhvien'.'/'.$item -> masv)}}">
                                        <input type="checkbox" name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="{{URL::to('/editsinhvien/'.$item -> masv)}}"><i class="dw dw-edit2"></i> Edit</a>
                                <form action="{{URL::to('/deletesinhvien/'.$item -> masv)}}" method="POST">
                                    {{ csrf_field() }}
                                    {{-- <a><i class="dw dw-delete-3"></i> Delete</a> --}}
                                    <button type="submit" class="show-alert-delete-box" data-toggle="tooltip" title='Delete'><i class="dw dw-delete-3"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10" class="text-center">không tìm thấy dữ liệu</td>
                    </tr>
                    
                    @endif
                </tbody>
            </table>
        
            @endif
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#tablesinhvien').DataTable();
        } );
    </script>
    {{-- popup warning  --}}
    <script type="text/javascript">
        $('.show-alert-delete-box').click(function(event){
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Bạn chắc chắn muốn xóa?",
                text: "Nếu như xóa, dữ liệu sẽ không thể khôi phục",
                icon: "warning",
                type: "warning",
                buttons: ["Cancel","Yes!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    </script>

@endsection

