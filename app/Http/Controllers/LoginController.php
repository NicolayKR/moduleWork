<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request){
        if(Auth::check()){
            return redirect()->intended(route('user.private'));
        }
        $formFields = $request->only(['email','password']);
        //Попытаемся соединиться с такими полями
        //Метод attempt вытаскивает пользователя из хранилища и если он есть перезодит в приват
        //Метод intended перекидыват либо на нужный адресс, либо туда откада мы сюда редиректнули
        if(Auth::attempt($formFields)){
            return redirect()->intended(route('user.private'));
        }
        return redirect(route('user.login'))->withErrors([
            'email' =>'Не удалось авторизироваться'
        ]);

    }
}
