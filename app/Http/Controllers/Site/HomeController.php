<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the site home page.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('site.pages.home');
    }

    /**
     * Show the site home page.
     *
     * @return Renderable
     */
    public function profile(): Renderable
    {
        return view('profile');
    }
}
