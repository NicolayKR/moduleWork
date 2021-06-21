<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <title>Авторизация</title>
</head>
<body>
<div class="container">
    <h1 class="login_title">Вход</h1>
    <form class="col-lg-6  offset-lg-3 col-sm-8 offset-sm-2 border rounded mt-3" method="POST" action="{{ route('user.login') }}">
        @csrf
        <div class="form-group">
            <label for="email" class="col-form-label-lg">Ваш email</label>
            <input class="form-control" id="email" name="email" type="text" value="" placeholder="Email">
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="col-form-label-lg">Пароль</label>
            <input class="form-control" id="password" name="password" type="password" value="" placeholder="Пароль">
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <div class="d-grid">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        Запомнить меня
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group d-grid">
            <div class="login_button-wrapper">
                <button class="btn btn-lg btn-primary btn-primary-autorise" type="submit" name="sendMe" value="1">Войти</button>
                <a class="btn btn-lg btn-primary btn-primary-autorise" href="/registration">Регистрация</a>
            </div>
        </div>
    </form>
</div>
    
<script src="./js/app.js"></script>

</body>
</html>