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
                        <li class="breadcrumb-item active" aria-current="page">Danh sách hình thức đào tạo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">DANH SÁCH HÌNH THỨC ĐÀO TẠO</h4>
            <div class="pull-right">
                <form class="form-inline" action="{{URL::to('/viewhtdt')}}" method="GET">
                    <div class="form-group mx-sm-3 mb-2">
                      <input type="search" name="keyword" class="form-control" id="example-search-input" placeholder="Search...">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
        <div class="pb-20">
            <table id="tblhe" class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th  class="table-plus">Mã htđt</th>
                        <th class="datatable-nosort">Tên htđt</th>
                        <th class="datatable-nosort">Hiển thị</th>
                        <th class="datatable-nosort">Create_at</th>
                        <th class="datatable-nosort">Update_at</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($viewhtdt as $key => $item)    
                        <tr>
                            <td class="table-plus">{{$item -> mahtdt}}</td>
                            <td>{{$item -> tenhtdt}}</td>
                            <td>
                                @if ($item -> status == 1)
                                    <a href="{{URL::to('/hiden_htdt'.'/'.$item -> mahtdt)}}">
                                        <input type="checkbox" checked name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                                    </a>
                                @else
                                    <a href="{{URL::to('/show_htdt'.'/'.$item -> mahtdt)}}">
                                        <input type="checkbox" name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                                    </a>
                                @endif
                            </td>
                            <td>{{$item -> create_at}}</td>
                            <td>{{$item -> update_at}}</td>
                            <td>
                                <a href="{{URL::to('/edithtdt/'.$item -> mahtdt)}}"><i class="dw dw-edit2"></i> Edit</a>
                                <form action="{{URL::to('/deletehtdt'.'/'.$item -> mahtdt)}}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" class="show-alert-delete-box" data-toggle="tooltip" title='Delete'><i class="dw dw-delete-3"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-block">
                
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

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