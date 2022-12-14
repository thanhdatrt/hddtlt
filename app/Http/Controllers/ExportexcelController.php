<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\khdtExport;
use App\Exports\gtcdExport;


class ExportexcelController extends Controller
{
    public function AuthLogin(){
        $id = Session::get('id');
        if($id){
            return Redirect::to('home');
        }
        else{
            return Redirect::to('/') -> send();
        }
    }

    public function inkhdt_excel($masv, $manganh, $mahtdt){
        $this -> AuthLogin();
        
        $filenameExport = 'khdt-'.$masv.'-'.$manganh.'.xlsx';
        return Excel::download(new khdtExport($masv, $manganh, $mahtdt), $filenameExport);
    }

    public function ingtcd_excel($masv, $manganh, $mahtdt, $mahe, $makhoa, $khoactdt){
        $this -> AuthLogin();

        $filenameExport = 'QĐMG-'.$manganh.'.xlsx';
        return Excel::download(new gtcdExport($masv, $manganh, $mahtdt, $mahe, $makhoa, $khoactdt), $filenameExport);
    }
}
