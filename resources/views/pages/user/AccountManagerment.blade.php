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
                        <li class="breadcrumb-item" aria-current="page">Cài đặt</li>
                        <li class="breadcrumb-item active" aria-current="page">Quản lý tài khoản</li>
                    </ol>   
                </nav>
            </div>
        </div>
    </div>
    
    <div class="card-box mb-30">
        <div class="p-20">
            <h4 style="margin-left: 10px; padding-top: 10px" class="text-blue h4">THÊM TÀI KHOẢN</h4>
        </div>
        <?php
            $adduser = Session::get('adduser');
            if($adduser) {
                echo '<div class="alert alert-danger" role="alert">'.$adduser.'</div>';
                Session::put('adduser', null);
            }
        ?>
        <div class="p-20">
            <form action="{{URL::to('/adduser')}}" method="post">
                @csrf
                <div style="margin-left: 10px" class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email...">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Họ Tên</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập họ tên...">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="password" class="col-form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập password...">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <button style="margin-top:38px" type="submit" class="btn btn-primary mb-2">Thêm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="p-20">
            <h4 style="margin-left: 10px" class="text-blue h4">DANH SÁCH TÀI KHOẢN</h4>
        </div>
        <?php
            $message = Session::get('message');
            if($message) {
                echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
                Session::put('message', null);
            }
        ?>
        <div class="pb-20">
            @if (isset($users))
                
            <table id="tablemonhoc" class="tablemonhoc data-table table stripe hover warp">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="datatable-nosort">Email</th>
                        <th class="datatable-nosort">Tên</th>
                        <th class="datatable-nosort">Số điện thoại</th>
                        {{-- <th class="datatable-nosort">Mật khẩu</th> --}}
                        <th class="datatable-nosort">Create_at</th>
                        <th class="datatable-nosort">Update_at</th>
                        <th class="datatable-nosort">Quyền</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users) > 0)
                    @foreach ($users as $key => $item)    
                        <tr>
                            <td>{{$item -> id}}</td>
                            <td>{{$item -> email}}</td>
                            <td>{{$item -> name}}</td>
                            <td>{{$item -> phone}}</td>
                            {{-- <td>
                                {{$item -> password}}
                            </td> --}}
                            <td>{{$item -> created_at}}</td>
                            <td>{{$item -> updated_at}}</td>
                            <td>
                                @if ($item -> status == 1)
                                    <a href="{{URL::to('/hidden_user/'.$item -> id)}}">
                                        <input type="checkbox" checked name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                                    </a>
                                @else
                                    <a href="{{URL::to('/show_user/'.$item -> id)}}">
                                        <input type="checkbox" name="hienthi" class="switch-btn" data-size="small" data-color="#0099ff">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <form action="{{URL::to('/deleteuser/'.$item -> id)}}" method="POST">
                                    {{ csrf_field() }}
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

            {{ $users->appends(request()->all())->links(); }}

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

        const toggleButton = document.querySelector('#toggle-password-button');
        const passwordField = document.querySelector('#password');
        const closedEye = document.querySelector('#closed-eye');
        const openEye = document.querySelector('#open-eye');
        let isPasswordHidden = true;
        toggleButton.addEventListener('click', function() {
        if (isPasswordHidden) {
        passwordField.type = 'text';
        openEye.classList.remove('hide');
        openEye.classList.add('show');
        closedEye.classList.add('hide');
        closedEye.classList.remove('show');
        } else {
        passwordField.type = 'password';
        closedEye.classList.remove('hide');
        closedEye.classList.add('show');
        openEye.classList.add('hide');
        openEye.classList.remove('show');
        }
        isPasswordHidden = !isPasswordHidden;
        });
    </script>

@endsection

