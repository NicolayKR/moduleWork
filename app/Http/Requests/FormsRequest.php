<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormsRequest extends FormRequest
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
    public function rules()
    {
        return [
            'email' =>'required',
            'password'=>'required|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'confimpassword'=>'required'
        ];
    }
    public function attributes(){
        return [
            'email'=>'Email',
            'password'=>'Пароль',
            'confimpassword'=>'Повторите пароль'
        ];
    }
    public function messages(){
        return[
            'email.required'=>'Поле Email - Обязательное',
            'password.required'=>'Поле Пароль - обязательное',
            'password.min'=>'Пароль должен содержать больше 6 символов',
            'password.regex'=>'Пароль должен содержать (минимум 1 цифру, а также строчный и заглавный символы)',
            'confimpassword.required'=>'Подтверждение пароля - обязательное',
        ];
    }

}
