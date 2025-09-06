<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class DashboardController extends BaseController
{

    public function __construct()
    {
        $this->module = 'dashboard';
    }

    public function index(): View
    {
        $this->data = [
            'module' => __('Admin'),
            'title' => __('Dashboard')
        ];

        return $this->render('index');
    }
}
