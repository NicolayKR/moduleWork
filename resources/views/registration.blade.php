<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <title>Регистрация</title>
</head>
<body>
<div class="container">
    <h1 class="registration_title">Регистрация</h1>
    <form class="col-lg-6 offset-lg-3 col-sm-10 offset-sm-1 col-10 offset-1 border rounded mt-3" method="POST" action="{{route('user.registration')}}">
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
            <label for="confim_password" class="col-form-label-lg">Повторите пароль</label>
            <input class="form-control" id="confim_password" name="confim_password" type="password" value="" placeholder="Пароль">
        </div>
        <div class="form-group d-grid">
            <div class="registration_button-wrapper">
                <a class="btn btn-lg btn-primary btn-primary-autorise" href="/login">Назад</a>
                <button class="btn btn-lg btn-primary btn-primary-autorise" type="submit" name="sendMe" value="1">Зарегистрироваться</button>
            <div>
        </div>
    </form>
</div>

<script src="./js/app.js"></script>
</body>
</html>