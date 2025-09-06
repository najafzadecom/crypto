@extends('site/layouts/app')
@section('content')
    <div class="nk-wrap">
        <main class="nk-pages nk-pages-centered bg-theme">
            <div class="ath-container">
                <div class="ath-header text-center">
                    <a href="{{ localizedRoute('home') }}" class="ath-logo">
                        <img
                            src="{{ asset('site/assets/images/logo-full-white.png') }}"
                            srcset="{{ asset('site/assets/images/logo-full-white2x.png') }} 2x"
                            alt="logo"
                        />
                    </a>
                </div>
                <div class="ath-body">
                    <h5 class="ath-heading title">
                        {{ __('Reset') }}
                        <small class="tc-default">{{ __('with your Email') }}</small>
                    </h5>
                    <form action="{{ localizedRoute('password.email') }}" method="POST">
                        @csrf
                        <div class="field-item">
                            <div class="field-wrap">
                                <input type="email" name="email" class="input-bordered" placeholder="{{ __('Your Email') }}">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-md">{{ __('Reset Password') }}</button>
                    </form>
                </div>
                <div class="ath-note text-center tc-light">
                    {{ __('Remembered?') }} <a href="{{ localizedRoute('login') }}"> <strong>{{ __('Sign in here') }}</strong></a>
                </div>
            </div>
        </main>
    </div>
@endsection
