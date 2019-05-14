<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // public function rules()
    // {
    //     return [
    //         'email'     =>'email', 
    //             'password'  =>'required|min:3|max:32',
    //     ];
    // }

    // public function messages()
    // {
    //     return [
    //         'email.email'               =>'Bạn chưa nhập đúng định dạng Email',
    //             'password.required'         =>'Bạn chưa nhập password',
    //             'password.min'              =>'Mật khẩu phải có ít nhất 3 ký tự',
    //             'password.max'              =>'Mật khẩu chỉ có nhiều nhất 32 ký tự',
    //     ];
    // }
}
