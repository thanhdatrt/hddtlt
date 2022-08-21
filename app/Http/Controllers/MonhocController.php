<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use MonhocModel;


class MonhocController extends Controller
{
    public function viewmonhoc(Request $request){
        
        if(isset($_GET['keyword'])){
            $keyword = $_GET['keyword'];
            $listsearch = DB::table('monhoc') -> where('tenhp', 'LIKE', '%'.$keyword.'%') ->orWhere('mahp', 'LIKE', '%'.$keyword.'%') -> paginate(15);
            $listsearch -> appends($request -> all());
            return view('pages.monhoc.viewmonhoc') -> with('viewmonhoc', $listsearch);;
        } 
        else{
            $listmonhoc = DB::table('monhoc') -> simplePaginate(15);
            $listmonhoc -> appends($request -> all());
            return view('pages.monhoc.viewmonhoc') -> with('viewmonhoc', $listmonhoc);
        }
    }

    public function addmonhoc(){

        return view('pages.monhoc.addmonhoc');
    }

    // action save mon hoc
    public function savemonhoc(Request $request){
        $data = array();
        $temp_mahp = $request -> mamonhoc;
        $data['mahp'] = $request -> mamonhoc;
        $data['tenhp'] = $request -> tenmonhoc;
        $data['tinchi'] = $request -> tinchi;
        $data['tinchilt'] = $request -> tinchilt;
        $data['sotietlt'] = $request -> sotietlt;
        $data['tinchith'] = $request -> tinchith;
        $data['sotietth'] = $request -> sotietth;
        $data['ghichuhp'] = $request -> ghichu;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['create_at'] = new dateTime('now');
        
        $result = DB::table('monhoc') -> where('mahp', $temp_mahp) -> first();
        if($result){
            Session::put('message', 'Môn học đã tồn tại!!!');
            return redirect::to('addmonhoc');
        }
        else if($request -> tenmonhoc == ''){
            Session::put('message', 'Tên môn học không được để trống!!!');
            return redirect::to('addmonhoc');
        }
        else{
            DB::table('monhoc') -> insert($data);
            Session::put('message', 'Thêm môn học thành công');
            return redirect::to('addmonhoc');
        }
    }

    // show - hiden mon hoc
    public function hiden_monhoc($mahp){
        DB::table('monhoc') -> where('mahp', $mahp) -> update(['status'=> 0]);
        return redirect::to('viewmonhoc');
    }

    public function show_monhoc($mahp){
        DB::table('monhoc') -> where('mahp', $mahp) -> update(['status'=> 1]);
        return redirect::to('viewmonhoc');
    }

    // GET edit mon hoc
    public function editmonhoc($mahp){
        $listmonhoc = DB::table('monhoc') -> where('mahp', $mahp) -> get();
        $result_editmonhoc = view('pages.monhoc.editmonhoc') -> with('editmonhoc', $listmonhoc);
        return view('layout') -> with('pages.monhoc.editmonhoc', $result_editmonhoc);
        return redirect::to('editmonhoc');
    }
    // POST edit mon hoc
    public function action_editmonhoc(Request $request, $mahp){
        $data = array();
        $data['tenhp'] = $request -> tenmonhoc;
        $data['tinchi'] = $request -> tinchi;
        $data['tinchilt'] = $request -> tinchilt;
        $data['sotietlt'] = $request -> sotietlt;
        $data['tinchith'] = $request -> tinchith;
        $data['sotietth'] = $request -> sotietth;
        $data['ghichuhp'] = $request -> ghichu;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['update_at'] = new dateTime('now');
        
        if($request -> tenmonhoc == ''){
            Session::put('message', 'Tên môn học không được để trống!!!');
            return redirect::to('editmonhoc');
        }
        else{
            DB::table('monhoc') -> where('mahp', $mahp) -> update($data);
            Session::put('message', 'Cập nhật môn học thành công');
            return redirect::to('viewmonhoc');
        }
    }

    // delete mon hoc
    public function deletemonhoc($mahp){
        DB::table('monhoc') -> where('mahp', $mahp) -> delete();
        return redirect::to('viewmonhoc');
    }

    // import excel
    public function import_excel(Request $request){
        Excel::import(new ExcelImport, $request -> file('filemonhoc') -> store('files'));
        return redirect() -> back();
    }

}
