<!DOCTYPE html>
<html lang="vn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In KHĐT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
       body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 13px;
        }
        .title{
            font-size: 14px;
            text-transform: uppercase;
        }
        .desc{
            font-size: 12px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table style="border: none; width: 100%;">
                    <tr>
                        <td><div class="text-center"> ỦY BAN NHÂN DÂN</div></td>
                        <td><div class="text-center font-weight-bold">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div></td>
                    </tr>
                    <tr>
                        <td><div class="text-center"> TỈNH TRÀ VINH</div></td>
                        <td><div class="text-center font-weight-bold"><u>Độc lập - Tự do - Hạnh phúc</u></div></td>
                    </tr>
                    <tr>
                        <td><div class="text-center font-weight-bold">TRƯỜNG ĐẠI HỌC TRÀ VINH</div></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="text-center title font-weight-bold">KẾ HOẠCH ĐÀO TẠO NGÀNH 
                    {{$tennganh}}
                </div>
                <div class="text-center title font-weight-bold">{{$tenhtdt}} </div>
                <div class="text-center desc font-italic">(Ban hành kèm theo Quyết định số: &nbsp;&nbsp;&nbsp; /QĐ-ĐHTV, ngày &nbsp;&nbsp;&nbsp; tháng &nbsp;&nbsp;&nbsp; năm 202 &nbsp;&nbsp; <br> của Hiệu trưởng Trường Đại học Trà Vinh)</div>
            </div>
        </div>
        <div class="row">  
            @foreach ($sinhvien as $key => $value)
            
            <table style="border: none; width: 100%;">
                <tr>
                    <td>Họ và tên: <span>{{$value -> hoten}}</span></td>
                    <td>ngày sinh: {{$value -> ngaysinh}}</td>
                </tr>
                <tr>
                    <td>Mã sinh viên: {{$value -> masv}}</td>
                    <td>Mã hồ sơ: {{$value -> mahs}}</td>
                </tr>
                <tr>
                    <td><div>Mã lớp: {{$value -> malop}}</div></td>
                </tr>
            </table>
            @endforeach
        </div>
        
        <div class="font-weight-bold">A. KẾ HOẠCH THỰC HIỆN</div>

        
    </div>
    <table class="table table-bordered" style="width: 100%;">
        <tr>
            <th rowspan="2" style="width:20px" class="text-center align-middle">STT</th>
            <th rowspan="2" style="width:50px" class="text-center align-middle">Mã HP</th>
            <th rowspan="2" style="width:150px" class="text-center align-middle">Tên học phần</th>
            <th rowspan="2" style="width:40px" class="text-center align-middle">Tổng số tín chỉ</th>
            <th colspan="2" style="width:120px" class="text-center align-middle">Lý thuyết</th>
            <th colspan="2" style="width:120px" class="text-center align-middle">Thực hành</th>
            <th rowspan="2" style="width:40px" class="text-center align-middle">Ghi chú HP</th>
        </tr>
        <tr>
            <th style="font-size: 10px" class="text-center align-middle">Tín chỉ</th>
            <th style="font-size: 10px" class="text-center align-middle">Số tiết</th>
            <th style="font-size: 10px" class="text-center align-middle">Tín chỉ</th>
            <th style="font-size: 10px" class="text-center align-middle">Số tiết</th>
        </tr>
        @foreach ($sv_ctdt as $key => $item)
        @if ($item -> inkhdt == 1)
        <tr>
            <td class="text-center">{{$item -> stt}}</td>
            <td class="text-center">{{$item -> mahp}}</td>
            <td class="text-center">{{$item -> tenhp}}</td>
            <td class="text-center">{{$item -> tinchi}}</td>
            <td class="text-center">{{$item -> tinchilt}}</td>
            <td class="text-center">{{$item -> sotietlt}}</td>
            <td class="text-center">{{$item -> tinchith}}</td>
            <td class="text-center">{{$item -> sotietth}}</td>
            <td class="text-center">{{$item -> ghichuhp}}</td>
        </tr>
        @endif
        @endforeach
        
        <tr>
            <td class="text-center" colspan="3" >Tổng cộng:</td>
            <td class="text-center">{{$tongtinchi}}</td>
            <td class="text-center">{{$tongtinchilt}}</td>
            <td class="text-center">{{$tongsotietlt}}</td>
            <td class="text-center">{{$tongtinchith}}</td>
            <td class="text-center">{{$tongsotietth}}</td>
            <td class="text-center"></td>
        </tr>
        
    </table>

    <div class="row">
        <div class="col-12">
            <table style="border: none; width: 100%;">
                <tr>
                    <td style="width: 60%;" class="font-weight-bold">Tổng số tín chỉ toàn khóa</td>
                    <td></td>
                    <td>Tín chỉ</td>
                </tr>
                <tr>
                    <td style="width: 60%;">Các học phần bắt buộc</td>
                    <td></td>
                    <td>Tín chỉ</td>
                </tr>
                <tr>
                    <td style="width: 60%;">Tốt nghiệp</td>
                    <td></td>
                    <td>Tín chỉ</td>
                </tr>
                <tr>
                    <td>Chưa kể khối giáo dục thể chất.</td>
                </tr>
            </table>

            <div class="font-weight-bold">B. HƯỚNG DẪN THỰC HIỆN</div>
            <P>1. Những học phần được công nhận giá trị chuyển đổi kết quả học tập và khối lượng kiến thức được miễn trừ khi học chương trình đào tạo không thể hiện kế hoạch đào tạo này</P>
            <p>2. BẢng điểm toàn khóa học chỉ thể hiện những học phần có trong kế hoạch đào tạo</p>
        </div>
    </div>
        
    <table style="border: none; width: 100%;">
        <tr>
            <td style="width: 33%;" class="text-center font-weight-bold">KT.HIỆU TRƯỞNG <br> PHÓ HIỆU TRƯỞNG </td>
            <td style="width: 33%;" class="text-center font-weight-bold">KHOA</td>
            <td style="width: 33%;" class="text-center font-weight-bold">BỘ MÔN</td> 
        </tr>
        <tr>
            <td style="height: 80px;"></td>
        </tr>
        <tr>
            <td class="text-center font-weight-bold">Nguyễn Minh Hòa</td>
        </tr>
    </table>


</body>
</html>