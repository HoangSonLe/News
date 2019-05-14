<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\TheLoai;
use App\Comment;

class UserController extends Controller
{
    public function getDanhSach(){
    	$users = User::all();
    	return view('admin.user.danhsach',['users'  => $users]);
    }

    public function getThem(){
    	return view('admin.user.them');
    }
    public function postThem(Request $request){
    	$this->validate($request,
    		[
    			'Ten'		=>'required|min:3',
    			'Email'		=>'required|email|unique:users,email', 
    			'Password'	=>'required|min:3|max:32',
    			'PasswordAgain'	=>'required|same:Password',
    		],

    		[
    			'Ten.required'				=>'Bạn chưa nhập tên',
    			'Ten.min'					=>'Tên người dùng phải có ít nhất 3 ký tự',
    			'Email.required'			=>'Bạn chưa nhập Email',
    			'Email.email'				=>'Bạn chưa nhập đúng định dạng Email',
    			'Email.unique'				=>'Email đã tồn tại',
    			'Password.required'			=>'Bạn chưa nhập password',
    			'Password.min'				=>'Mật khẩu phải có ít nhất 3 ký tự',
    			'Password.max'				=>'Mật khẩu chỉ có nhiều nhất 32 ký tự',
    			'PasswordAgain.required'	=>'Bạn chưa nhập lại mật khẩu',
    			'PasswordAgain.same'		=>'Mật khẩu nhập lại chưa đúng',

    		]);
    	$user = new User;
    	$user->name = $request->Ten;
    	$user->email = $request->Email;
    	$user->password = bcrypt($request->Password);
    	$user->quyen = $request->Level;

    	$user->save();
    	return redirect('admin/user/them')->with('thongbao','Đã thêm thành công');
    }

    public function getSua($id){
    	$user =User::find($id);
    	return view('admin.user.sua',['user'	=> $user]);
    }

    public function postSua(Request $request, $id){
    	$this->validate($request,
    		[
    			'Ten'		=>'required|min:3',
    		],

    		[
    			'Ten.required'				=>'Bạn chưa nhập tên',
    			'Ten.min'					=>'Tên người dùng phải có ít nhất 3 ký tự',

    		]);
    	$user = User::find($id);
    	$user->name = $request->Ten;
    	$user->quyen = $request->Level;


    	if(isset($request->changePassword)){
    		$this->validate($request,
    		[
    			'Password'	=>'required|min:3|max:32',
    			'PasswordAgain'	=>'required|same:Password',
    		],

    		[
    			'Password.required'			=>'Bạn chưa nhập password',
    			'Password.min'				=>'Mật khẩu phải có ít nhất 3 ký tự',
    			'Password.max'				=>'Mật khẩu chỉ có nhiều nhất 32 ký tự',
    			'PasswordAgain.required'	=>'Bạn chưa nhập lại mật khẩu',
    			'PasswordAgain.same'		=>'Mật khẩu nhập lại chưa đúng',

    		]);
    		$user->password = bcrypt($request->Password);
    		
    	}
    	$user->save();
    	return redirect('admin/user/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }
    public function getXoa($id){
    	$user = User::find($id);
    	if(null!== Comment::where('idUser',$id)){

	    	$comment = Comment::where('idUser',$id); //Tìm các comment của user 
	    	$comment->delete(); //Xóa các comment của user 
    	}
    	$user->delete(); //Xóa user
    	return redirect('admin/user/danhsach')->with('thongbao','Xóa tài khoản thành công');
    }

    public function getLogin(){
    	if(Auth::check())
    		return redirect('admin/theloai/danhsach')->with('thongbao','Bạn đã đăng nhập');
    	return view('admin.login');
    }
    public function postLogin(Request $request){
    	// $this->validate($request,
    	// 	[
    	// 		'email'		=>'required', 
    	// 		'password'	=>'required|min:3|max:32',
    	// 	],

    	// 	[
    	// 		'email.required'			=>'Bạn chưa nhập Email',
    	// 		'email.email'				=>'Bạn chưa nhập đúng định dạng Email',
    	// 		'email.unique'				=>'Email đã tồn tại',
    	// 		'password.required'			=>'Bạn chưa nhập password',
    	// 		'password.min'				=>'Mật khẩu phải có ít nhất 3 ký tự',
    	// 		'password.max'				=>'Mật khẩu chỉ có nhiều nhất 32 ký tự',

    	// 	]);
    	if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    		return redirect('admin/theloai/danhsach');
    	}
    	else{
    		return redirect('admin/login')->with('thongbao','Đăng nhập không thành công');

    	}
    }
    public function getLogout(){
    	Auth::logout();
    	return redirect('admin/login');
    }
}
