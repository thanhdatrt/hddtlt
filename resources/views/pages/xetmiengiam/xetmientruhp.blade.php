@extends('layout')
@section('content')

    <style>
        fieldset
        {
            max-width:280px;
            /* padding:10px; */
        }
        legend {
            padding-right: 32px;
            color: gray;
            font-size: 90%;
            text-align: center;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }
    </style>

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
                        <li class="breadcrumb-item active" aria-current="page">Nhập dữ liệu xét miễn trừ</li>
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
            <form action="{{URL::to('/filterdata')}}" method="GET">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="col-sm-6 col-md-12 col-form-label">Mã hệ</label>
                            <div class="col-sm-6 col-md-12">
                                <select class="form-control" name="mahe" id="mahe" class="form-select">
                                    <option selected disabled>------Select------</option>
                                    @if (isset($listhe))    
                                    @foreach ($listhe as $key => $he)
                                        @if (isset($mahe))    
                                            @if ($he == $mahe)
                                                <option selected value="{{$he}}">{{$he}}</option>
                                            @else
                                                <option value="{{$he}}">{{$he}}</option>
                                                @endif
                                        @else
                                            <option value="{{$he}}">{{$he}}</option>
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
                                        @if (isset($makhoa))    
                                            @if ($khoa == $makhoa)
                                                <option selected value="{{$khoa}}">{{$khoa}}</option>
                                            @else
                                                <option value="{{$khoa}}">{{$khoa}}</option>
                                                @endif
                                        @else
                                            <option value="{{$khoa}}">{{$khoa}}</option>
                                        @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="col-sm-6 col-md-12 col-form-label">Mã ngành</label>
                            <div class="col-sm-6 col-md-12">
                                <select class="form-control" name="manganh" id="manganh" class="form-select">
                                    <option selected disabled>------Select------</option>
                                    @if (isset($listnganh))    
                                    @foreach ($listnganh as $key => $nganh)
                                    @if (isset($makhoa))    
                                        @if ($nganh == $manganh)
                                            <option selected value="{{$nganh}}">{{$nganh}}</option>
                                        @else
                                            <option value="{{$nganh}}">{{$nganh}}</option>
                                            @endif
                                    @else
                                        <option value="{{$nganh}}">{{$nganh}}</option>
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
                                    @if (isset($makhoa))    
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
                    <div class="col">
                        <div class="form-group">
                            <label class="col-sm-6 col-md-12 col-form-label">Mã sinh viên</label>
                            <div class="col-sm-6 col-md-12">
                                <select class="form-control" name="masv" id="masv" class="form-select">
                                    <option selected disabled>------Select------</option>
                                    @if (isset($listmasv))
                                    @foreach ($listmasv as $key => $sv)
                                    @if (isset($makhoa))    
                                        @if ($sv == $masv)
                                            <option selected value="{{$sv}}">{{$sv}}</option>
                                        @else
                                            <option value="{{$sv}}">{{$sv}}</option>
                                        @endif
                                    @else
                                        <option value="{{$sv}}">{{$sv}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button style="margin-left: 80px; margin-top: 38px" type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-filter"></i> Lọc</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-20">
            <form action="{{URL::to('/capnhat')}}" method="post" >
                @csrf
                @if (isset($sv_ctdt))
                <div class="row">
                    
                    <div class="col-5">
                        <fieldset>
                            <legend class="legend1">PDF</legend>
                            <a href="{{URL::to('/inkhdt/'.$masv.'/'.$manganh.'/'.$mahtdt)}}" class="btn btn-info"><i class="fa-solid fa-print"></i> In KHĐT</a>
                            <a href="{{URL::to('/ingtcd/'.$masv.'/'.$manganh.'/'.$mahtdt.'/'.$mahe.'/'.$makhoa)}}" class="btn btn-info"><i class="fa-solid fa-print"></i> In GTCĐ</a>
                        </fieldset>
                    </div>
                    <div class="col-5">
                        <fieldset>
                            <legend class="legend1">EXCEL</legend>
                            <a href="{{URL::to('/inkhdt-excel/'.$masv.'/'.$manganh.'/'.$mahtdt)}}" class="btn btn-info"><i class="fa-solid fa-print"></i> In KHĐT</a>
                            <a href="{{URL::to('/ingtcd-excel/'.$masv.'/'.$manganh.'/'.$mahtdt.'/'.$mahe.'/'.$makhoa)}}" class="btn btn-info"><i class="fa-solid fa-print"></i> In GTCĐ</a>
                        </fieldset>
                    </div>
                        
                </div>
                    <div class="pull-right">
                        <button style="margin-bottom: 10px" class="btn btn-primary" type="submit">Lưu</button>
                    </div> 
                <table style="margin-top: 20px" class="tablemonhoc data-table table stripe hover warp">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th class="datatable-nosort">Mã hp</th>
                            <th class="datatable-nosort">Tên hp</th>
                            <th class="datatable-nosort">tín chỉ</th>
                            <th class="datatable-nosort">tín chỉlt</th>
                            <th class="datatable-nosort">số tiếtlt</th>
                            <th class="datatable-nosort">tín chỉth</th>
                            <th class="datatable-nosort">số tiếtth</th>
                            <th class="datatable-nosort">ghi chúhp</th>
                            <th class="datatable-nosort">tự chọn</th>
                            <th class="datatable-nosort">tín chỉtc</th>
                            <th class="datatable-nosort">miễn trừ</th>
                            <th class="datatable-nosort">ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sv_ctdt) > 0)
                        @foreach ($sv_ctdt as $key => $item)
                                @csrf
                                <tr>
                                    <td>{{$item -> stt}}</td>
                                    <td> 
                                        <input type="hidden" name="mahp[]" hidden value="{{$item -> mahp}}" >
                                        {{$item -> mahp}}
                                    </td>
                                    <td>{{$item -> tenhp}}</td>
                                    <td>
                                        <input type="hidden" name="tinchi[]" value="{{$item -> tinchi}}">
                                        {{$item -> tinchi}}    
                                    </td>
                                    <td>{{$item -> tinchilt}}</td>
                                    <td>{{$item -> sotietlt}}</td>
                                    <td>{{$item -> tinchith}}</td>
                                    <td>{{$item -> sotietth}}</td>
                                    <td>{{$item -> ghichuhp}}</td>
                                    <td>
                                        <input name="tuchon[]" type="hidden" value="{{$item -> tuchon}}">
                                        {{$item -> tuchon}}
                                    </td>

                                    <td>
                                        <input name="sotinchitc[]" type="hidden" value="{{$item -> sotinchitc}}">
                                        {{$item -> sotinchitc}}
                                    </td>

                                    <td>
                                        @if ($item -> mientru == 0)
                                            <input value="0" id="mientru" name="status_checkbox[]" type="hidden"/>
                                            <input value="1" id="mientru" name="status_checkbox[]" type="checkbox"/>
                                        @else
                                            <input value="0" id="mientru" name="status_checkbox[]" type="hidden"/>
                                            <input value="1" id="mientru" name="status_checkbox[]" type="checkbox" checked/>
                                        @endif
                                        <input type="hidden" name="masv" value="{{$masv}}">
                                        
                                    </td>

                                    <td>
                                        <input type="text" name="ghichu[]" value="{{$item -> ghichu}}"class="form-control">
                                    </td>
                                </tr>
                        @endforeach
                        @endif
                                
                    </tbody>
                </table>
            </form>
            {{-- {{ $sv_ctdt->appends(request()->all())->links(); }} --}}
            @else
                <p class="text-center">không có dữ liệu</p>
            @endif
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@endsection

