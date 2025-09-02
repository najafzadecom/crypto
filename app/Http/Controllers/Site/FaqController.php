<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Contracts\Support\Renderable;

class FaqController extends Controller
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
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $faqs = Faq::query()->where('status', 1)->get();

        return view('site.pages.faq', compact('faqs'));
    }
}
