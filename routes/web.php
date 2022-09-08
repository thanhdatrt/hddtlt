<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonhocController;
use App\Http\Controllers\HeController;
use App\Http\Controllers\KhoahocController;
use App\Http\Controllers\NganhController;
use App\Http\Controllers\LopController;
use App\Http\Controllers\HinhthucdtController;
use App\Http\Controllers\SinhvienController;
use App\Http\Controllers\CtdtController;
use App\Http\Controllers\XmgController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportexcelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [homeController::class, 'index']);
// trang chu
Route::get('/home', [homeController::class, 'home']);
// xu ly dang nhap
Route::post('/dashboard', [homeController::class, 'dashboard']);
// dang xuat
Route::get('/logout', [homeController::class, 'logout']);


// xet mien giam
Route::get('/dongbo', [xmgController::class, 'dongbo']);
Route::get('/xetmientruhp', [xmgController::class, 'xetmientruhp']);
Route::get('/filterdata', [xmgController::class, 'filterdata']);
Route::get('/dadongbo', [xmgController::class, 'dadongbo']);
Route::get('/huydongbo/{masv}/{manganh}', [xmgController::class, 'huydongbo']);

Route::post('/capnhat', [xmgController::class, 'capnhat']);

// xuat file pdf
Route::get('/inkhdt/{masv}/{manganh}/{mahtdt}', [xmgController::class, 'inkhdt']);
Route::get('/ingtcd/{masv}/{manganh}/{mahtdt}/{mahe}/{makhoa}', [xmgController::class, 'ingtcd']);

// xuat file excel
Route::get('/inkhdt-excel/{masv}/{manganh}/{mahtdt}', [exportexcelController::class, 'inkhdt_excel']);
Route::get('/ingtcd-excel/{masv}/{manganh}/{mahtdt}/{mahe}/{makhoa}/{khoactdt}', [exportexcelController::class, 'ingtcd_excel']);

Route::get('/savesinhvien-ctdt/{masv}/{manganh}/{mahe}/{khoactdt}', [xmgController::class, 'savesinhvien_ctdt']);
Route::post('/save_miengiam/{mahp}/{masv}', [xmgController::class, 'save_miengiam']);


// user
Route::get('/profile', [userController::class, 'profile']);
Route::get('/accountmanager', [userController::class, 'AccountManager']);
Route::post('/capnhattt', [userController::class, 'capnhattt']);
Route::post('/doimatkhau', [userController::class, 'doimatkhau']);
Route::get('/show_user/{id}', [userController::class, 'show_user']);
Route::get('/hidden_user/{id}', [userController::class, 'hidden_user']);
Route::post('/deleteuser/{id}', [userController::class, 'deleteuser']);
Route::post('/adduser', [userController::class, 'addUser']);


//mon hoc
Route::get('/viewmonhoc', [monhocController::class, 'viewmonhoc']);
Route::get('/addmonhoc', [monhocController::class, 'addmonhoc']);
Route::post('/savemonhoc', [monhocController::class, 'savemonhoc']);
Route::get('/hiden_monhoc/{mahp}', [monhocController::class, 'hiden_monhoc']);
Route::get('/show_monhoc/{mahp}', [monhocController::class, 'show_monhoc']);
Route::get('/editmonhoc/{mahp}', [monhocController::class, 'editmonhoc']);
Route::post('/action_editmonhoc/{mahp}', [monhocController::class, 'action_editmonhoc']);
Route::post('/deletemonhoc/{mahp}', [monhocController::class, 'deletemonhoc']);
Route::post('/import_excel', [monhocController::class, 'import_excel']);

// he 
Route::get('/addhe', [heController::class, 'addhe']);
Route::get('/viewhe', [heController::class, 'viewhe']);
Route::post('/savehe', [heController::class, 'savehe']);
Route::get('/hiden_he/{mahe}', [heController::class, 'hiden_he']);
Route::get('/show_he/{mahe}', [heController::class, 'show_he']);
Route::get('/edithe/{mahe}', [heController::class, 'edithe']);
Route::post('/action_edithe/{mahe}', [heController::class, 'action_edithe']);
Route::post('/deletehe/{mahe}', [heController::class, 'deletehe']);

// khoa hoc
Route::get('/addkhoahoc', [khoahocController::class, 'addkhoahoc']);
Route::get('/viewkhoahoc', [khoahocController::class, 'viewkhoahoc']);
Route::post('/savekhoahoc', [khoahocController::class, 'savekhoahoc']);
Route::get('/hiden_khoahoc/{makhoahoc}', [khoahocController::class, 'hiden_khoahoc']);
Route::get('/show_khoahoc/{makhoahoc}', [khoahocController::class, 'show_khoahoc']);
Route::get('/editkhoahoc/{makhoahoc}', [khoahocController::class, 'editkhoahoc']);
Route::post('/action_editkhoahoc/{makhoahoc}', [khoahocController::class, 'action_editkhoahoc']);
Route::post('/deletekhoahoc/{makhoahoc}', [khoahocController::class, 'deletekhoahoc']);

// nganh hoc
Route::get('/addnganh', [nganhController::class, 'addnganh']);
Route::get('/viewnganh', [nganhController::class, 'viewnganh']);
Route::post('/savenganh', [nganhController::class, 'savenganh']);
Route::get('/hiden_nganh/{manganh}', [nganhController::class, 'hiden_nganh']);
Route::get('/show_nganh/{manganh}', [nganhController::class, 'show_nganh']);
Route::get('/editnganh/{manganh}', [nganhController::class, 'editnganh']);
Route::post('/action_editnganh/{manganh}', [nganhController::class, 'action_editnganh']);
Route::post('/deletenganh/{manganh}', [nganhController::class, 'deletenganh']);

// lop
Route::get('/addlop', [lopController::class, 'addlop']);
Route::get('/viewlop', [lopController::class, 'viewlop']);
Route::post('/savelop', [lopController::class, 'savelop']);
Route::get('/hiden_lop/{malop}', [lopController::class, 'hiden_lop']);
Route::get('/show_lop/{malop}', [lopController::class, 'show_lop']);
Route::get('/editlop/{malop}', [lopController::class, 'editlop']);
Route::post('/action_editlop/{malop}', [lopController::class, 'action_editlop']);
Route::post('/deletelop/{malop}', [lopController::class, 'deletelop']);

// hình thức đào tạo
Route::get('/addhtdt', [hinhthucdtController::class, 'addhtdt']);
Route::get('/viewhtdt', [hinhthucdtController::class, 'viewhtdt']);
Route::post('/savehtdt', [hinhthucdtController::class, 'savehtdt']);
Route::get('/hiden_htdt/{mahtdt}', [hinhthucdtController::class, 'hiden_htdt']);
Route::get('/show_htdt/{mahtdt}', [hinhthucdtController::class, 'show_htdt']);
Route::get('/edithtdt/{mahtdt}', [hinhthucdtController::class, 'edithtdt']);
Route::post('/action_edithtdt/{mahtdt}', [hinhthucdtController::class, 'action_edithtdt']);
Route::post('/deletehtdt/{mahtdt}', [hinhthucdtController::class, 'deletehtdt']);

// chuong trình đao tao
Route::get('/viewctdt', [ctdtController::class, 'viewctdt']);
Route::get('/addctdt', [ctdtController::class, 'addctdt']);
Route::get('/addctdt', [ctdtController::class, 'loaddropdownctdt']);
Route::post('/savectdt', [ctdtController::class, 'savectdt']);
Route::get('/hiden_ctdt/{mahp}', [ctdtController::class, 'hiden_ctdt']);
Route::get('/show_ctdt/{mahp}', [ctdtController::class, 'show_ctdt']);
Route::get('/editctdt/{mahp}', [ctdtController::class, 'editctdt']);
Route::post('/action_editctdt/{mahp}', [ctdtController::class, 'action_editctdt']);
Route::post('/deletectdt/{mahp}', [ctdtController::class, 'deletectdt']);
Route::post('/import_ctdt', [ctdtController::class, 'import_excel']);

// sinh vien
Route::get('/viewsinhvien', [sinhvienController::class, 'viewsinhvien']);
Route::get('/addsinhvien', [sinhvienController::class, 'addsinhvien']);
Route::get('/addsinhvien', [sinhvienController::class, 'loaddropdown']);
Route::post('/savesinhvien', [sinhvienController::class, 'savesinhvien']);
Route::get('/hiden_sinhvien/{masv}', [sinhvienController::class, 'hiden_sinhvien']);
Route::get('/show_sinhvien/{masv}', [sinhvienController::class, 'show_sinhvien']);
Route::get('/editsinhvien/{masv}', [sinhvienController::class, 'editsinhvien']);
Route::post('/action_editsinhvien/{masv}', [sinhvienController::class, 'action_editsinhvien']);
Route::post('/deletesinhvien/{masv}', [sinhvienController::class, 'deletesinhvien']);
Route::post('/import_sinhvien', [sinhvienController::class, 'import_excel']);