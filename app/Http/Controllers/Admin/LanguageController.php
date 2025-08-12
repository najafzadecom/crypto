<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Store\LanguageRequest as StoreRequest;
use App\Http\Requests\Update\LanguageRequest as UpdateRequest;
use App\Services\LanguageService as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class LanguageController extends BaseController
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->middleware('permission:languages-index|languages-create|languages-edit', ['only' => ['index']]);
        $this->middleware('permission:languages-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:languages-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:languages-delete', ['only' => ['destroy']]);

        $this->service = $service;
        $this->module = 'languages';
    }

    public function index()
    {
        $this->data = [
            'module' => __('Languages'),
            'title' => __('List'),
            'items' => $this->service->paginate()
        ];

        return $this->render('list');
    }

    public function create()
    {
        $this->data = [
            'title' => __('Create'),
            'module' => __('Languages'),
            'method' => 'POST',
            'action' => route('admin.' . $this->module . '.store')
        ];

        return $this->render('form');
    }

    public function store(StoreRequest $request)
    {
        $item = $this->service->create($request->validated());

        return $this->redirectSuccess('admin.languages.index');
    }

    public function show(string $id)
    {
        $this->data = [
            'item' => $this->service->getById($id)
        ];

        return $this->json();
    }

    public function edit(string $id)
    {
        $item = $this->service->getById($id);
        
        $this->data = [
            'title' => __('Edit'),
            'module' => __('Languages'),
            'item' => $item,
            'method' => 'PUT',
            'action' => route('admin.' . $this->module . '.update', $id)
        ];

        return $this->render('form');
    }

    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return $this->redirectSuccess('admin.languages.index');
    }

    public function destroy(string $id): JsonResponse
    {
        // Check if delete confirmation was received
        if (!request()->has('confirmed')) {
            $this->data = [
                'message' => __('Delete confirmation required'),
                'confirmed' => false
            ];
            
            return $this->json(422);
        }

        $message = __('Unknown error');
        $code = 500;

        if ($this->service->delete($id)) {
            $message = __('Delete successfully');
            $code = 200;
        }

        $this->data = [
            'message' => $message
        ];

        return $this->json($code);
    }

    public function restore(string $id): JsonResponse
    {
        $message = __('Unknown error');
        $code = 500;

        if ($this->service->restore($id)) {
            $message = __('Restore successfully');
            $code = 200;
        }

        $this->data = [
            'message' => $message
        ];

        return $this->json($code);
    }

    public function delete(string $id): JsonResponse
    {
        $code = 500;
        $message = __('Unknown error');

        if ($this->service->forceDelete($id)) {
            $code = 200;
            $message = __('Force delete successfully');
        }

        $this->data = [
            'message' => $message
        ];

        return $this->json($code);
    }
}
