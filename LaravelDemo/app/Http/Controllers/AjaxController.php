<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\Comment;
use App\TinTuc;

class AjaxController extends Controller
{
    public function getLoaiTin($idTheLoai){
    	$loaitin = LoaiTin::where('idTheLoai',$idTheLoai)->get();
    	foreach($loaitin as $lt){
    		echo "<option value='".$lt->id."'>".$lt->Ten."</option>";
    	}
    }

    public function getXoaComment($idComment){
    	$comment = Comment::find($idComment);
    	$comment->delete();
    	$tintuc = TinTuc::find($comment->idTinTuc);
    	$html="";
    	foreach($tintuc->comment as $cm){
    		$html.= '<tr class="odd gradeX" align="center">';
    		$html.= "<td>".$cm->id."</td>";
    		$html.= "<td>".$cm->user->name."</td>";
    		$html.= "<td>".$cm->NoiDung."</td>";
    		$html.= "<td>".$cm->created_at."</td>";
    		$html.= "<td class='center'><i class='fa fa-trash-o  fa-fw'></i><a class='Xoa' id='".$cm->id."' href='admin/comment/xoa/".$cm->id."/".$tintuc->id."'> Xóa</a></td>";
    		$html.="</tr>";
    	}
    	return $html;
    }
}
