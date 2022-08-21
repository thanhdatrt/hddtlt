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
                        <li class="breadcrumb-item active" aria-current="page">Danh sách Môn học</li>
                    </ol>   
                </nav>
            </div>
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">DANH SÁCH MÔN HỌC</h4>

            <div class="pull-left">
                <form class="form-inline" action="{{URL::to('/import_excel')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <input name="filemonhoc" type="file" class="form-control-file form-control height-auto">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-plus"></i> import excel</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="pull-right">
                <div class="input-group">
                    <form class="form-inline" action="{{URL::to('/viewmonhoc')}}" method="GET">
                        <div class="form-group mx-sm-3 mb-2">
                          <input type="search" name="keyword" class="form-control" id="example-search-input" placeholder="Search...">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <a class="btn mb-2"href="{{URL::to('/viewmonhoc')}}"><i class="fa-solid fa-arrows-rotate"></i></a>
                    </form>
                </div>
            </div>
        </div>

        <div class="pb-20">
            @if (isset($viewmonhoc))
                
            <table id="tablemonhoc" class="tablemonhoc data-table table stripe hover warp">
                <thead>
                    <tr>
                        <th>Mã Môn học</th>
                        <th class="datatable-nosort">Tên Môn học</th>
                        <th class="datatable-nosort">tín chỉ</th>
                        <th class="datatable-nosort">tclt</th>
                        <th class="datatable-nosort">sotietlt</th>
                        <th class="datatable-nosort">tcth</th>
                        <th class="datatable-nosort">sotietth</th>
                        <th class="datatable-nosort">Hiển thị</th>
                        <th class="datatable-nosort">Create_at</th>
                        <th class="datatable-nosort">Update_at</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($viewmonhoc) > 0)
                    @foreach ($viewmonhoc as $key => $item)    
                        <tr>
                            <td>{{$item -> mahp}}</td>
                            <td>{{$item -> tenhp}}</td>
                            <td>{{$item -> tinchi}}</td>
                            <td>{{$item -> tinchilt}}</td>
                            <td>{{$item -> sotietlt}}</td>
                            <td>{{$item -> tinchith}}</td>
                            <td>{{$item -> sotietth}}</td>
                            <td>
                                @if ($item -> status == 1)
                                    <a href="{{URL::to('/hiden_monhoc/'.$item -> mahp)}}">
                                        <input type="checkbox" checked name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                                    </a>
                                @else
                                    <a href="{{URL::to('/show_monhoc/'.$item -> mahp)}}">
                                        <input type="checkbox" name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                                    </a>
                                @endif
                            </td>
                            <td>{{$item -> create_at}}</td>
                            <td>{{$item -> update_at}}</td>
                            <td>
                                <a href="{{URL::to('/editmonhoc/'.$item -> mahp)}}"><i class="dw dw-edit2"></i> Edit</a>
                                <form action="{{URL::to('/deletemonhoc/'.$item -> mahp)}}" method="POST">
                                    {{ csrf_field() }}
                                    {{-- <a><i class="dw dw-delete-3"></i> Delete</a> --}}
                                    <button type="submit" class="show-alert-delete-box" data-toggle="tooltip" title='Delete'><i class="dw dw-delete-3"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10" class="text-center">không tìm thấy</td>
                    </tr>
                    
                    @endif
                </tbody>
            </table>
            {{ $viewmonhoc->appends(request()->all())->links(); }}
            @endif
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 
    

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

