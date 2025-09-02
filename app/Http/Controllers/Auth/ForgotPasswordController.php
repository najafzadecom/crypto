<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | Bu controller parol sıfırlama e-maillərini göndərmək üçün cavabdehdir.
    | SendsPasswordResetEmails trait-i istifadə olunur.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('site.pages.auth.forgot-password');
    }

}
