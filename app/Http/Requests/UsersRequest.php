<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $uniqueUsernameExcept = "";
        $passwordRule = 'required|min:6';
        if(!empty($request->get('id'))){
            $uniqueUsernameExcept = $request->get('id');
            // Nếu không nhập mật khẩu thì mặc định mật khẩu cũ, nếu có nhập thì phải 6 ký tự
            $passwordRule = '';
            if(!empty($request->post('password'))){
                $passwordRule = 'min:6';
            }
        }

        return [
            'fullname' => 'required',
            'username' => 'required|min:5|unique:users,username'.$uniqueUsernameExcept,
            'password' => $passwordRule
        ];
    }
    public function messages(){
        return [
            'fullname.required' => 'Vui lòng nhập tên nhân viên',
            'username.required' => 'Vui lòng nhập tài khoản',
            'username.min' => 'Tài khoản tối thiểu :min ký tự',
            'username.unique' => 'Tài khoản đã tồn tại'
        ];
    }
    public function failedValidation(Validator $validator){
        $response = new Response([
            'errors' => $validator->errors(),
            'status' => false,
            'message' => 'Dữ liệu không hợp lệ'
        ]);

        throw (new ValidationException($validator, $response));
    }
}
