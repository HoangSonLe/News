<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TinTuc;
use App\TheLoai;

class LoaiTinController extends Controller
{
     public function getDanhSach(){
    	$loaitin = LoaiTin::all();
    	return view('admin.loaitin.danhsach',['loaitin' =>$loaitin]);
    }

    public function getThem(){
    	$theloai =TheLoai::all();
    	return view('admin.loaitin.them',['theloai' =>$theloai]);
    }

    public function postThem(Request $request){
    	$this->validate($request,
    		[
    			'txtCateName' =>'required|min:2|max:100|unique:LoaiTin,Ten',
    			'TheLoai' =>'required'
    		],

    		[
    			'TheLoai.required'=>'Name is required',
    			'txtCateName.required'=>'Name is required',
    			'txtCateName.min'=>'Name is too short',
    			'txtCateName.max'=>'Name is too long',
    			'txtCateName.unique' =>'Name is existed'
    		]
    	);
    	$loaitin =new LoaiTin;
    	$loaitin->Ten = $request->txtCateName;
    	$loaitin->idTheLoai = $request->TheLoai;
    	// $theloai->TenKhongDau =changeTitle($request->txtCateName);
    	$loaitin->TenKhongDau =str_slug($request->txtCateName);
    	// echo str_slug($request->txtCateName,'-');//hoặc dùng cái này, tham số sau là kí tự nói

    	$loaitin->save();

    	return redirect('admin/loaitin/them')->with('thongbao','Đã thêm thành công');
    }

    public function getSua($id){
    	$loaitin= LoaiTin::find($id);
    	$theloai = TheLoai::all();
    	return view('admin.loaitin.sua',['loaitin' => $loaitin,'theloai' =>$theloai]);
    }

    public function postSua(Request $req,$id){
    	$loaitin= LoaiTin::find($id);
    	$this->validate($req,
    	[
    		'txtCateName'		=>'required|min:2|max:100',
    		'TheLoai' =>'required'
    	],
    	[
    		'TheLoai.required' =>'Name is required',
    		'txtCateName.required' =>'Name is required',
    		'txtCateName.min' =>'Name is too short',
    		'txtCateName.max' =>'Name is long'
    	]);

    	$loaitin->Ten=$req->txtCateName;
    	$loaitin->TenKhongDau=str_slug($req->txtCateName);
    	$loaitin->idTheLoai=$req->TheLoai;
    	$loaitin->save();
    	return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }

    public function getXoa($id){//xóa này còn thiếu nếu ở các bảng có quan hệ
        $tintuc = TinTuc::where('idLoaiTin',$id)->count();
        if($tintuc == 0){
            $loaitin = LoaiTin::find($id);
            $loaitin->delete();
            return redirect('admin/loaitin/danhsach')->with('thongbao','Đã xóa thành công');
        }
        else{
            echo "<script type='text/javascript'>
                alert('Xin lỗi !!! Bạn không thể xóa loại tin này !!! Xin kiểm tra lại !!!');
                window,location = '";
                    echo url('admin/loaitin/danhsach');
                    // echo route('admin.loaitin.danhsach');
            echo "';
            </script>";
        }
    	
    }
}
