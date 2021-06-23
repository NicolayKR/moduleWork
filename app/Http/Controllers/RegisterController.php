<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FormsRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function save(FormsRequest $request){
        //Проверяем, авторизован ли уже пользователь
        if(Auth::check()){
            return redirect(route('user.private'));
        }
        $validateFields =  $request->only(['email','password']);
        if(User::where('email', $validateFields['email'])->exists()){
            return redirect(route('user.registration'))->withErrors([
                'email' =>'Такая почта уже используется'
            ]);
        }
        if($request->strlen(input('confimpassword')) == 0 ){
            return redirect(route('user.registration'))->withErrors([
                'confimpassword' =>'Поле не может быть пустым',
             ]);
        }
        if($request->input('password') == $request->input('confimpassword')){
            date_default_timezone_set("Europe/Moscow");
            $user = User::create($validateFields);
            if($user){
                Auth::login($user);//Аунтифицируем пользователя
                return redirect(route('user.private'));
            }
        }
        else {
            return redirect(route('user.registration'))->withErrors([
               'password' =>'Пароли не совпадают',
            ]);
        }
        //Если что-то пойдет не так вернем на страницу ошибку к которой потом сможем обращаться
        return redirect(route('user.login'))->withErrors([
            'formError' =>'Произошла ошибка при сохранении пользователя'
        ]);
    }
}
