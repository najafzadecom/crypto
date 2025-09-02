<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\Support\Renderable;

class PageController extends Controller
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
     * @param Page $page
     * @return Renderable
     */
    public function show(Page $page): Renderable
    {
        return view('page.show', compact('page'));
    }
}
