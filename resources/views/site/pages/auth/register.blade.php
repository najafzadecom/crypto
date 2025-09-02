@extends('site/layouts/app')
@section('content')
    <div class="nk-wrap">
        <main class="nk-pages nk-pages-centered bg-theme">
            <div class="ath-container">
                <div class="ath-header text-center">
                    <a href="{{ route('home') }}" class="ath-logo">
                        <img src="{{ asset('site/assets/images/logo-full-white.png') }}"
                             srcset="{{ asset('site/assets/images/logo-full-white2x.png') }} 2x"
                             alt="logo"
                        />
                    </a>
                </div>
                <div class="ath-body">
                    <h5 class="ath-heading title">{{ __('Sign Up') }}
                        <small class="tc-default">{{ __('Create New Account') }}</small>
                    </h5>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="field-item">
                            <div class="field-wrap">
                                <input type="text" name="name" class="input-bordered" placeholder="{{ __('Your Name') }}">
                            </div>
                        </div>
                        <div class="field-item">
                            <div class="field-wrap">
                                <input type="email" name="email" class="input-bordered" placeholder="{{ __('Your Email') }}">
                            </div>
                        </div>
                        <div class="field-item">
                            <div class="field-wrap">
                                <input type="password" name="password" class="input-bordered" placeholder="{{ __('Password') }}">
                            </div>
                        </div>
                        <div class="field-item">
                            <div class="field-wrap">
                                <input type="password" name="password_confirmation" class="input-bordered" placeholder="{{ __('Repeat Password') }}">
                            </div>
                        </div>
                        <div class="field-item">
                            <input class="input-checkbox" id="agree-term-2" type="checkbox">
                            <label for="agree-term-2">
                                {{ __('I agree with') }} <a href="#">Privacy Policy</a> &amp; <a href="#">Terms</a>.
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-md">{{ __('Sign Up') }}</button>
                    </form>
                    <div class="sap-text"><span>{{ __('Or Sign Up With') }}</span></div>
                    <ul class="btn-grp gutter-20px gutter-vr-20px">
                        <li class="col">
                            <a href="#" class="btn btn-md btn-google btn-block">
                                <em class="icon fab fa-google"></em>
                                <span>{{ __('Google') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ath-note text-center tc-light">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('login') }}"> <strong{{ __('>Sign in here') }}</strong></a>
                </div>
            </div>
        </main>
    </div>
@endsection
