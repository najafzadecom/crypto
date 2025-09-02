<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Contracts\Support\Renderable;

class NewsController extends Controller
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
     * @return Renderable
     */
    public function index(): Renderable
    {
        $items = News::query()->paginate();

        return view('site.pages.news', compact('items'));
    }

    /**
     * Show the application dashboard.
     *
     * @param News $news
     * @return Renderable
     */
    public function show(News $news): Renderable
    {
        return view('site.pages.news-show', compact('news'));
    }
}
