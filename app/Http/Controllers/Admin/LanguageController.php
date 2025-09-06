<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Store\LanguageRequest as StoreRequest;
use App\Http\Requests\Update\LanguageRequest as UpdateRequest;
use App\Services\LanguageService as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LanguageController extends BaseController
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->middleware('permission:language-index|language-create|language-edit', ['only' => ['index']]);
        $this->middleware('permission:language-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:language-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:language-delete', ['only' => ['destroy']]);

        $this->service = $service;
        $this->module = 'languages';
    }

    public function index(): View
    {
        $this->data = [
            'module' => __('Languages'),
            'title' => __('List'),
            'items' => $this->service->paginate()
        ];

        return $this->render('list');
    }

    public function create(): View
    {
        $flagIcons = $this->getFlagIcons();

        $this->data = [
            'title' => __('Create'),
            'module' => __('Languages'),
            'method' => 'POST',
            'action' => route('admin.' . $this->module . '.store'),
            'flagIcons' => $flagIcons
        ];

        return $this->render('form');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $item = $this->service->create($request->validated());

        return $this->redirectSuccess('admin.languages.index');
    }

    public function show(string $id): JsonResponse
    {
        $this->data = [
            'item' => $this->service->getById($id)
        ];

        return $this->json();
    }

    public function edit(string $id): View
    {
        $item = $this->service->getById($id);
        $flagIcons = $this->getFlagIcons();

        $this->data = [
            'title' => __('Edit'),
            'module' => __('Languages'),
            'item' => $item,
            'method' => 'PUT',
            'action' => route('admin.' . $this->module . '.update', $id),
            'flagIcons' => $flagIcons
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

    /**
     * Get all flag icons from the lang directory
     *
     * @return array
     */
    private function getFlagIcons(): array
    {
        $flagPath = public_path('admin/assets/images/lang');
        $flags = [];

        if (file_exists($flagPath) && is_dir($flagPath)) {
            $files = scandir($flagPath);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'svg') {
                    $countryName = pathinfo($file, PATHINFO_FILENAME);
                    $flags[$file] = ucfirst($countryName);
                }
            }
        }

        return $flags;
    }
}
