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
                <h5 class="ath-heading title">{{ __('Sign in') }} <small class="tc-default">{{ __('with your account') }}</small></h5>
                <form action="{{ localizedRoute('login') }}" method="POST">
                    @csrf
                    <div class="field-item">
                        <div class="field-wrap">
                            <input type="email" name="email" class="input-bordered" required="required" placeholder="{{ __('Your Email') }}">
                        </div>
                    </div>
                    <div class="field-item">
                        <div class="field-wrap">
                            <input type="password" name="password" class="input-bordered" required="required" placeholder="{{ __('Password ') }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pdb-r">
                        <div class="field-item pb-0">
                            <input class="input-checkbox" id="remember-me-2" type="checkbox">
                            <label for="remember-me-2">{{ __('Remember Me') }}</label>
                        </div>
                        <div class="forget-link fz-6"><a href="{{ localizedRoute('password.request') }}">{{ __('Forgot password?') }}</a></div>
                    </div>
                    <button class="btn btn-primary btn-block btn-md">{{ __('Sign In') }}</button>
                </form>
                <div class="sap-text"><span>{{ __('Or Sign In With') }}</span></div>
                <ul class="row gutter-20px gutter-vr-20px">
                    <li class="col">
                        <a href="#" class="btn btn-md btn-google btn-block">
                            <em class="icon fab fa-google"></em>
                            <span>{{ __('Google') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="ath-note text-center tc-light">
                {{ __('Don’t have an account?') }}
                <a href="{{ localizedRoute('register') }}"> <strong>{{ __('Sign up here') }}</strong></a>
            </div>
        </div>
    </main>
</div>
@endsection
