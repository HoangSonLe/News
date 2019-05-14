<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
    	$theloai = TheLoai::all();
    	return view('admin.theloai.danhsach',['theloai' =>$theloai]);
    }

    public function getThem(){
    	return view('admin.theloai.them');
    }

    public function postThem(Request $request){
    	$this->validate($request,
    		[
    			'txtCateName' =>'required|min:2|max:100|unique:TheLoai,Ten'
    		],

    		[
    			'txtCateName.required'=>'Name is required',
    			'txtCateName.min'=>'Name is too short',
    			'txtCateName.max'=>'Name is too long',
    			'txtCateName.unique' =>'Name is existed'
    		]
    	);
    	$theloai =new TheLoai;
    	$theloai->Ten = $request->txtCateName;
    	// $theloai->TenKhongDau =changeTitle($request->txtCateName);
    	$theloai->TenKhongDau =str_slug($request->txtCateName);
    	// echo str_slug($request->txtCateName,'-');//hoặc dùng cái này, tham số sau là kí tự nói

    	$theloai->save();

    	return redirect('admin/theloai/them')->with('thongbao','Đã thêm thành công');
    }

    public function getSua($id){
    	$theloai= TheLoai::find($id);
    	return view('admin.theloai.sua',['theloai' => $theloai]);
    }

    public function postSua(Request $req,$id){
    	$theloai= TheLoai::find($id);
    	$this->validate($req,
    	[
    		'txtCateName'		=>'required|min:2|max:100|unique:TheLoai,Ten'

    	],
    	[
    		'txtCateName.required' =>'Name is required',
    		'txtCateName.min' =>'Name is too short',
    		'txtCateName.max' =>'Name is long',
    		'txtCateName.unique' =>'Name is existed'

    	]);

    	$theloai->Ten=$req->txtCateName;
    	$theloai->TenKhongDau=str_slug($req->txtCateName);
    	$theloai->save();
    	return redirect('admin/theloai/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }

    public function getXoa($id){
    	$theloai = TheLoai::find($id);
    	$theloai->delete();

    	return redirect('admin/theloai/danhsach')->with('thongbao','Đã xóa thành công');
    }
}
