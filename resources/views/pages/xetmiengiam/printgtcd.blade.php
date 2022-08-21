<!DOCTYPE html>
<html lang="vn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In GTCD</title>
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
    
    <div>
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
                <div class="text-center title font-weight-bold"> DANH SÁCH SINH VIÊN</div>
            </div>
            <div class="col-12">
                <div class=" font-weight-bold">Ngành: &nbsp;&nbsp;<span>{{$tennganh}}</span></div>
                <div class=" font-weight-bold">Bậc:&nbsp;&nbsp;&nbsp; <span>{{$tenhtdt}} </span> <span>{{$tenhe}}</span> </div>
                <div class=" desc font-italic">(Đính kèm theo Quyết định số: &nbsp;&nbsp;&nbsp; /QĐ-ĐHTV, ngày &nbsp;&nbsp;&nbsp; tháng &nbsp;&nbsp;&nbsp; năm 202 &nbsp;&nbsp; <br> của Hiệu trưởng Trường Đại học Trà Vinh về việc công nhận giá trị chuyển đổi kết quả học tập và khối lượng kiến thức, kỹ năng đã tích lũy các lớp <span>{{$tenhtdt}}</span> <span>{{$tenkhoa}}</span> )</div>
            </div>
        </div>
    </div>
    <br>
    <table class="table table-bordered" style="width: 100%;">
        <tr>
            <th style="width:20px" class="text-center align-middle">STT</th>
            <th style="width:80px" class="text-center align-middle">Mã hồ sơ</th>
            <th style="width:150px" class="text-center align-middle">Họ và tên</th>
            <th style="width:80px" class="text-center align-middle">Ngày sinh</th>
            <th style="width:80px" class="text-center align-middle">mã sinh viên</th>
            <th class="text-center align-middle">Tên môn học</th>
            <th style="width:60px" class="text-center align-middle">Số tín chỉ</th>
            <th style="width:80px" class="text-center align-middle">Công nhận (CN) GTCĐ KQHT</th>
        </tr>
        @foreach ($ctdt_sinhvien as $key => $item)
        @if ($item -> mientru == 1)
        <tr>
            <td class="text-center">{{$item -> stt}}</td>
            <td class="text-center">{{$mahs}}</td>
            <td class="text-center">{{$hoten}}</td>
            <td class="text-center">{{$ngaysinh}}</td>
            <td class="text-center">{{$item -> masv}}</td>
            <td class="text-center">{{$item -> tenhp}}</td>
            <td class="text-center">{{$item -> tinchi}}</td>
            <td class="text-center">CN</td>
        </tr>
        @endif
        @endforeach
        
    </table>

    
        
    <table style="border: none; width: 100%;">
        <tr>
            <td style="width: 33%;" class="text-center font-weight-bold"></td>
            <td style="width: 33%;" class="text-center font-weight-bold"></td>
            <td style="width: 33%;" class="text-center font-weight-bold">LẬP BẢNG</td> 
        </tr>
    </table>


</body>
</html>