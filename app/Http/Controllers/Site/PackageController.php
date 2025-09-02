<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Contracts\Support\Renderable;

class PackageController extends Controller
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
        $packages = Package::query()->where('status', 1)->get();

        return view('page.show', compact('packages'));
    }
}
