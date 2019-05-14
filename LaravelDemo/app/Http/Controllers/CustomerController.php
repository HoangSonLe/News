<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class CustomerController extends Controller
{
    function getLogin(){
    	if(Auth::check())
    		return redirect('trangchu');
    	return view('pages.login');
    }

    function postLogin(Request $request){
    	$this->validate($request,
    		[
    			'email'		=>'email', 
    			'password'	=>'required|min:3|max:32',
    		],

    		[
    			'email.email'				=>'Bạn chưa nhập đúng định dạng Email',
    			'password.required'			=>'Bạn chưa nhập password',
    			'password.min'				=>'Mật khẩu phải có ít nhất 3 ký tự',
    			'password.max'				=>'Mật khẩu chỉ có nhiều nhất 32 ký tự',

    		]);
    	if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    		return redirect('trangchu');
    	}
    	else{
    		return redirect('login')->with('thongbao','Đăng nhập không thành công');

    	}
    }

    function getLogout(){
    	Auth::logout();
    	return redirect('trangchu');
    }

    function getInform(){
    	return view('pages.information');
    }
    function postInform(Request $request){
    	$this->validate($request,
    		[
    			'name'		=>'required|min:3',
    		],

    		[
    			'name.required'				=>'Bạn chưa nhập tên',
    			'name.min'					=>'Tên người dùng phải có ít nhất 3 ký tự',

    		]);
    	$user = Auth::user();
    	$user->name = $request->name;

    	if(isset($request->changePassword)){
    		$this->validate($request,
    		[
    			'password'	=>'required|min:3|max:32',
    			'passwordAgain'	=>'required|same:password',
    		],

    		[
    			'password.required'			=>'Bạn chưa nhập password',
    			'password.min'				=>'Mật khẩu phải có ít nhất 3 ký tự',
    			'password.max'				=>'Mật khẩu chỉ có nhiều nhất 32 ký tự',
    			'passwordAgain.required'	=>'Bạn chưa nhập lại mật khẩu',
    			'passwordAgain.same'		=>'Mật khẩu nhập lại chưa đúng',

    		]);
    		$user->password = bcrypt($request->password);
    		
    	}
    	$user->save();
    	return redirect('nguoidung')->with('thongbao','Đã sửa thành công');
    }

    function getRegistry(){
    	return view('pages.dangky');
    }

    function postRegistry(Request $request){
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
    	$user->quyen = 0;

    	$user->save();
    	return redirect('registry')->with('thongbao','Đã đăng ký thành công');
    }
}
