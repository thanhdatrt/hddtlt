<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinhvienModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'masv',
        'mahs', 
        'mahe', 
        'mahtdt', 
        'hoten', 
        'ngaysinh', 
        'malop', 
        'khoactdt', 
        'makhoa', 
        'manganh', 
        'ghichu', 
        'status',
        'role',
        'create_at'
    ];
    protected $primaryKey = 'masv';
    protected $table = 'sinhvien';
}
