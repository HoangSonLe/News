<?php

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
use App\TheLoai;
Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/login', 'UserController@getLogin');

Route::post('admin/login', 'UserController@postLogin');

Route::get('admin/logout', 'UserController@getLogout');

Route::get('login', [
    'as' => 'login',
    'uses'  => 'Auth\LoginController@getLogin'

]);
Route::post('login', [
    'as' => 'login',
    'uses'  => 'Auth\LoginController@postLogin'

]);


Route::group(['prefix' => 'admin','middleware' => 'adminLogin'], function() {
    //thể loại
    Route::group(['prefix' => 'theloai'], function() {
    	
        Route::get('danhsach', 'TheLoaiController@getDanhSach');

        Route::get('sua/{id}', 'TheLoaiController@getSua');

        Route::post('sua/{id}', 'TheLoaiController@postSua');

        Route::get('them', 'TheLoaiController@getThem');
        
        Route::post('them', 'TheLoaiController@postThem');

        Route::get('xoa/{id}', 'TheLoaiController@getXoa');


    });

    //loại tin
    Route::group(['prefix' => 'loaitin'], function() {

        Route::get('danhsach',[
            'as' => 'admin.loaitin.danhsach',
            'uses'  => 'LoaiTinController@getDanhSach'
        ]);

        Route::get('sua/{id}', 'LoaiTinController@getSua');

        Route::post('sua/{id}', 'LoaiTinController@postSua');

        Route::get('them', 'LoaiTinController@getThem');
        
        Route::post('them', 'LoaiTinController@postThem');

        Route::get('xoa/{id}', 'LoaiTinController@getXoa');

    });

     //tin tức
    Route::group(['prefix' => 'tintuc'], function() {

        Route::get('danhsach', 'TinTucController@getDanhSach');

        Route::get('sua/{id}', 'TinTucController@getSua');

        Route::post('sua/{id}', 'TinTucController@postSua');

        Route::get('them', 'TinTucController@getThem');

        Route::post('them', 'TinTucController@postThem');

        Route::get('xoa/{id}', 'TinTucController@getXoa');


    });

     //tin tức
    Route::group(['prefix' => 'comment'], function() {
        Route::get('xoa/{id}/{idTinTuc}', 'CommentController@getXoa');
    });
    //ajax
    Route::group(['prefix' => 'ajax'], function() {
        Route::get('loaitin/{idTheLoai}', 'AjaxController@getLoaiTin');
        Route::get('comment/{idComment}', 'AjaxController@getXoaComment');
    });

     //slide
    Route::group(['prefix' => 'slide'], function() {

        Route::get('danhsach', 'SlideController@getDanhSach');

        Route::get('xoa/{id}', 'SlideController@getXoa');

        Route::get('them', 'SlideController@getThem');

        Route::post('them', 'SlideController@postThem');

        Route::get('sua/{id}', 'SlideController@getSua');

        Route::post('sua/{id}', 'SlideController@postSua');
    });

     //user
    Route::group(['prefix' => 'user'], function() {

        Route::get('danhsach', 'UserController@getDanhSach');

        Route::get('sua/{id}', 'UserController@getSua');

        Route::post('sua/{id}', 'UserController@postSua');

        Route::get('them', 'UserController@getThem');

        Route::post('them', 'UserController@postThem');

        Route::get('xoa/{id}', 'UserController@getXoa');
    });
});

Route::get('trangchu', 'PagesController@trangchu');

Route::get('lienhe', 'PagesController@lienhe');

Route::get('loaitin/{id}/{TenKhongDau}.html', 'PagesController@loaitin');

Route::get('tintuc/{id}/{TenKhongDau}.html', 'PagesController@tintuc');

Route::get('login','CustomerController@getLogin');

Route::post('login','CustomerController@postLogin');

Route::get('logout','CustomerController@getLogout');

Route::get('registry','CustomerController@getRegistry');

Route::post('registry','CustomerController@postRegistry');

Route::post('comment/{id}','CommentController@postComment');

Route::get('nguoidung','CustomerController@getInform');

Route::post('nguoidung','CustomerController@postInform');

Route::get('timkiem', 'PagesController@timkiem');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
