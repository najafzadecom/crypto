<?php

namespace App\Http\Controllers\Admin;

class DashboardController extends BaseController
{

    public function __construct()
    {
        $this->module = 'dashboard';
    }

    public function index()
    {
        $this->data = [
            'module' => __('Admin'),
            'title' => __('Dashboard')
        ];

        return $this->render('index');
    }
}
