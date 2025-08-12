<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Store\PackageRequest as StoreRequest;
use App\Http\Requests\Update\PackageRequest as UpdateRequest;
use App\Services\PackageService as Service;
use App\Services\LanguageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PackageController extends BaseController
{
    private Service $service;
    private LanguageService $languageService;

    public function __construct(Service $service, LanguageService $languageService)
    {
        $this->middleware('permission:packages-index|packages-create|packages-edit', ['only' => ['index']]);
        $this->middleware('permission:packages-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:packages-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:packages-delete', ['only' => ['destroy']]);

        $this->service = $service;
        $this->languageService = $languageService;
        $this->module = 'packages';
    }

    public function index()
    {
        $this->data = [
            'module' => __('Packages'),
            'title' => __('List'),
            'items' => $this->service->paginate(),
            'defaultLocale' => $this->languageService->getDefaultLocale()
        ];

        return $this->render('list');
    }

    public function create()
    {
        $this->data = [
            'title' => __('Create Package'),
            'method' => 'POST',
            'action' => route('admin.' . $this->module . '.store'),
            'languages' => $this->languageService->getActiveLanguages()
        ];

        return $this->render('form');
    }

    public function store(StoreRequest $request)
    {
        $item = $this->service->create($request->validated());

        return $this->redirectSuccess('admin.packages.index');
    }

    public function show(string $id)
    {
        $item = $this->service->getById($id);
        
        $this->data = [
            'id' => $item->id,
            'price' => $item->price,
            'image' => $item->image,
            'status' => $item->status,
            'status_html' => $item->status_html,
            'translations' => $item->translations,
            'created_at_formatted' => $item->created_at->format('d.m.Y H:i:s'),
            'updated_at_formatted' => $item->updated_at->format('d.m.Y H:i:s')
        ];

        return $this->json();
    }

    public function edit(string $id)
    {
        $item = $this->service->getById($id);
        
        $this->data = [
            'title' => __('Edit Package'),
            'item' => $item,
            'method' => 'PUT',
            'action' => route('admin.' . $this->module . '.update', $id),
            'languages' => $this->languageService->getActiveLanguages()
        ];

        return $this->render('form');
    }

    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return $this->redirectSuccess('admin.packages.index');
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
