<?php

namespace App\Http\Controllers\Admin;

use App\Services\ActivityLogService as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ActivityLogController extends BaseController
{
    private Service $service;

    public function __construct(
        Service $service
    )
    {
        $this->middleware('permission:activity-log-index', ['only' => ['index']]);

        $this->service = $service;
        $this->module = 'activity-logs';
    }

    public function index(): View
    {
        $this->data = [
            'module' => __('Activity Logs'),
            'title' => __('List'),
            'items' => $this->service->paginate()
        ];

        return $this->render('list');
    }

    public function show(string $id): JsonResponse
    {
        $this->data = [
            'item' => $this->service->getById($id)
        ];

        return $this->json();
    }
}
