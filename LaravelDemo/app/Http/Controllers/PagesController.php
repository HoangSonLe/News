<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
class PagesController extends Controller
{
	
    function trangchu(){
    	
    	return view('pages.trangchu');
    }

    function lienhe(){
    	return view('pages.contact');
    }

    function loaitin($id){
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
    	return view('pages.loaitin',['loaitin' => $loaitin,'tintuc' => $tintuc]);
    }

    function tintuc($id){
    	$tintuc = TinTuc::find($id);
    	$tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
    	$tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();

    	return view('pages.tintuc',['tintuc' => $tintuc,'tinnoibat' => $tinnoibat, 'tinlienquan' => $tinlienquan]);
    }

    function timkiem(Request $request){
        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5);
        return view('pages.timkiem',['tintuc' => $tintuc,'tukhoa' => $tukhoa]);

    }
}
