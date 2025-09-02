<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | Bu controller istifadəçilərin parollarını reset etməsini idarə edir.
    | ResetsPasswords trait-i bütün loqikanı təmin edir.
    |
    */

    use ResetsPasswords;

    /**
     * Resetdən sonra yönləndiriləcək route.
     *
     * @var string
     */
    protected $redirectTo = '/home';
}
