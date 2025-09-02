<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Laravel 8 və sonrası üçün
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | Bu controller yeni istifadəçilərin qeydiyyatını və onların
    | doğrulanmasını idarə edir. Default olaraq RegistersUsers traitindən
    | istifadə olunur.
    |
    */

    use RegistersUsers;

    /**
     * Qeydiyyatdan sonra yönləndiriləcək URL.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Yeni controller instance yaradılır.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('site.pages.auth.register');
    }

    /**
     * Gələn qeydiyyat sorğusu üçün validator.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Qeydiyyatdan keçmiş istifadəçi instance-i yaratmaq.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
