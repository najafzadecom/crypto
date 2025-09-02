<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Support\Renderable;

class CategoryController extends Controller
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
     * @param Category $category
     * @return Renderable
     */
    public function show(Category $category): Renderable
    {
        return view('site.pages.news', compact('category'));
    }
}
