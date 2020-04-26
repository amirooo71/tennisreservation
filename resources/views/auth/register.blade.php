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
                    <h3 class="kt-login__title">فرم ثبت نام</h3>
                </div>
                <div class="kt-login__form">
                    <form class="kt-form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <input id="name"
                                   type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   placeholder="نام"
                                   value="{{ old('name') }}"
                                   required
                                   autocomplete="name" autofocus>
                            @component('components.validation',['field' => 'name'])
                            @endcomponent
                        </div>
                        <div class="form-group">
                            <input id="email"
                                   type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   placeholder="ایمیل"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email">
                            @component('components.validation',['field' => 'email'])
                            @endcomponent
                        </div>
                        <div class="form-group">
                            <input id="password"
                                   type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="رمز عبور"
                                   required autocomplete="new-password">
                            @component('components.validation',['field' => 'password'])
                            @endcomponent
                        </div>
                        <div class="form-group">
                            <input id="password-confirm"
                                   placeholder="تکرار رمز عبور"
                                   type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password">
                        </div>
                        <div class="kt-login__actions">
                            <button class="btn btn-brand btn-pill btn-elevate">ثبت نام</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-login__account">
        <a href="{{route('login')}}" class="kt-login__account-link">ورود</a>
    </div>

@endsection





