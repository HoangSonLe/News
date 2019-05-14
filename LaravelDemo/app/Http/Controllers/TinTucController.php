<?php
//chưa check size của hình ảnh thêm vào
//chưa check trùng ảnh của sửa hình ảnh thêm vào
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\TinTuc;
use App\TheLoai;
use App\LoaiTin;
use App\Comment;
use App\Hinh;
use Input;

class TinTucController extends Controller
{
     public function getDanhSach(){
    	// $tintuc = TinTuc::orderBy('id','DESC')->get();
    	$tintuc = TinTuc::paginate(10);
    	return view('admin.tintuc.danhsach',['tintuc' =>$tintuc]);
    }

    public function getThem(){
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	return view('admin.tintuc.them',['theloai' => $theloai , 'loaitin' => $loaitin]);
    }

    public function postThem(Request $request){
    	$this->validate($request,
    		[
    			'TieuDe'   =>'required|min:2|max:100|unique:TheLoai,Ten',
    			'LoaiTin'  =>'required',
    			'TheLoai'  =>'required',
    			'TomTat'   =>'required',
    			'NoiDung'  =>'required',

    		],

    		[
    			'TieuDe.required'	=>'Thiếu tên tiêu đề',
    			'TieuDe.min'		=>'Tên tiêu đề quá ngắn (có ít nhất 3 kí tự)',
    			'TieuDe.max'		=>'Tên tiêu đề quá dài (không có 100 kí tự)',
    			'TieuDe.unique' 	=>'Tiêu đề đã tồn tại',
    			'LoaiTin.required'	=>'Chưa chọn loại tin',
    			'TheLoai.required'	=>'Chưa chọn thể loại',
    			'NoiDung.required'	=>'Chưa nhập nội dung',
    			'TomTat.required'	=>'Chưa nhập tóm tắt',
    		]
    	);
    	$tintuc =new TinTuc;
    	$tintuc->TieuDe = $request->TieuDe;
    	$tintuc->TieuDeKhongDau =str_slug($request->TieuDe);
    	$tintuc->idLoaiTin= $request->LoaiTin;
    	$tintuc->TomTat= $request->TomTat;
    	$tintuc->NoiDung= $request->NoiDung;
    	$tintuc->SoLuotXem= 0;

    	if($request->hasFile('Hinh')){
    		$file = $request->file('Hinh');
    		$duoi = $file->getClientOriginalExtension();
    		if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg')
    		{
    			return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file có đuôi là jpg,png,jpeg');
    		}
    		$name = $file->getClientOriginalName();
    		$Hinh = str_random(4)."_". $name;
    		while(file_exists("upload/tintuc/".$Hinh))
    		{

    			$Hinh = str_random(4)."_". $name;

    		}
    		$file->move("upload/tintuc",$Hinh);
    		$tintuc->Hinh= $Hinh;
    	}

    	else{

    		$tintuc->Hinh="";
    	}
    	$tintuc->save();
        if($request->hasFile('fNewsDetail')){
            foreach ($request->file('fNewsDetail') as $file) {
                $newsImageDetail = new Hinh;
                if(isset($file)){
                    $newsImageDetail->image = $file->getClientOriginalName();
                    $newsImageDetail->news_id = $tintuc->id;
                    $file->move("upload/tintuc/detail",$file->getClientOriginalName());
                    $newsImageDetail->save();
                }
            }
        }

    	return redirect('admin/tintuc/them')->with('thongbao','Đã thêm thành công');
    }



    public function getSua($id){
    	
    	$theloai = TheLoai::all();
    	$tintuc = TinTuc::find($id);
        $images = Hinh::where('news_id','=',$id)->get();
    	$loaitin = LoaiTin::where('idTheLoai',"=",$tintuc->loaitin->theloai->id)->get();
    	return view('admin.tintuc.sua',['theloai' => $theloai,'tintuc' => $tintuc,'loaitin' => $loaitin, 'images' => $images]);
    }

    public function postSua(Request $request,$id){
    	$tintuc= TinTuc::find($id);
    	$this->validate($request,
    		[
    			'TieuDe'   =>'required|min:2|max:100|unique:TheLoai,Ten',
    			'LoaiTin'  =>'required',
    			'TheLoai'  =>'required',
    			'TomTat'   =>'required',
    			'NoiDung'  =>'required',
    			// 'Hinh' => 'required|image|mimes:jpg,jpeg,png'﻿
    		],

    		[
    			'TieuDe.required'	=>'Thiếu tên tiêu đề',
    			'TieuDe.min'		=>'Tên tiêu đề quá ngắn (có ít nhất 3 kí tự)',
    			'TieuDe.max'		=>'Tên tiêu đề quá dài (không có 100 kí tự)',
    			'TieuDe.unique' 	=>'Tiêu đề đã tồn tại',
    			'LoaiTin.required'	=>'Chưa chọn loại tin',
    			'TheLoai.required'	=>'Chưa chọn thể loại',
    			'NoiDung.required'	=>'Chưa nhập nội dung',
    			'TomTat.required'	=>'Chưa nhập tóm tắt',
    			// 'Hinh.mimes'		=>'Hình không đúng định dạng',
    		]
    	);

    	$tintuc->TieuDe = $request->TieuDe;
    	$tintuc->TieuDeKhongDau =str_slug($request->TieuDe);
    	$tintuc->idLoaiTin= $request->LoaiTin;
    	$tintuc->TomTat= $request->TomTat;
    	$tintuc->NoiDung= $request->NoiDung;

    	if($request->hasFile('Hinh')){
    		$file = $request->file('Hinh');
    		$duoi = $file->getClientOriginalExtension();
    		if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg')
    		{
    			return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file có đuôi là jpg,png,jpeg');
    		}
    		$name = $file->getClientOriginalName();
    		$Hinh = str_random(4)."_". $name;
    		while(file_exists("upload/tintuc/".$Hinh))
    		{

    			$Hinh = str_random(4)."_". $name;

    		}
    		$file->move("upload/tintuc",$Hinh);
    		if($tintuc->Hinh){ 
    			unlink("upload/tintuc/".$tintuc->Hinh); 
    		} 
    		$tintuc->Hinh= $Hinh;
    	}

    	$tintuc->save();

        if($request->hasFile('fNewsDetail')){
            foreach ($request->file('fNewsDetail') as $file) {
                $newsImageDetail = new Hinh;
                if(isset($file)){
                    $newsImageDetail->image = $file->getClientOriginalName();
                    $newsImageDetail->news_id = $id;
                    $file->move("upload/tintuc/detail/",$file->getClientOriginalName());
                    $newsImageDetail->save();
                }
            }
        }
    	return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }



    public function getXoa($id){
    	$tintuc = TinTuc::find($id);
        if($tintuc->Hinh!="" && file_exists("upload/tintuc/".$tintuc->Hinh)){ 
                unlink("upload/tintuc/".$tintuc->Hinh); 
        } 
        $image = Hinh::where('news_id','=',$id)->get();
        foreach ($image as $key) {
           if($key->image!="" && file_exists("upload/tintuc/detail/".$key->image)){ 
            // echo $key->image;
                unlink("upload/tintuc/detail/".$key->image); 
                $key->delete();
        }  
        $tintuc->delete();
    }

    	return redirect('admin/tintuc/danhsach')->with('thongbao','Đã xóa thành công');
    }
}
