@extends('layouts.auth')

@section('content')

    <div class="kt-login__container">
        <div class="kt-login__body">
            <div class="kt-login__logo">
                <a href="#">
                    <img src="{{asset('images/tennis-128x128.png')}}">
                </a>
            </div>
            <div class="kt-login__signin">
                <div class="kt-login__head">
                    <h3 class="kt-login__title">فرم ورود</h3>
                </div>
                <div class="kt-login__form">
                    <form class="kt-form" action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="ایمیل" name="email" id="email"
                                   autocomplete="off"
                                   value="{{old('email')}}">
                            @error('email')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-last" type="password" placeholder="رمز عبور"
                                   name="password" id="password" value="{{old('password')}}">
                            @error('password')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="kt-login__extra">
                            <label class="kt-checkbox">
                                <input type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}> مرا به
                                خاطر بسپار
                                <span></span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">رمز عبور خود را فراموش کرده اید؟</a>
                            @endif
                        </div>
                        <div class="kt-login__actions">
                            <button class="btn btn-brand btn-pill btn-elevate">ورود</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
