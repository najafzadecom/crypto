<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Store\RegionRequest as StoreRequest;
use App\Http\Requests\Update\RegionRequest as UpdateRequest;
use App\Services\RegionService as Service;
use App\Services\CountryService;
use App\Services\LanguageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegionController extends BaseController
{
    private Service $service;
    private CountryService $countryService;
    private LanguageService $languageService;

    public function __construct(Service $service, CountryService $countryService, LanguageService $languageService)
    {
        $this->middleware('permission:region-index|region-create|region-edit', ['only' => ['index']]);
        $this->middleware('permission:region-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:region-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:region-delete', ['only' => ['destroy']]);

        $this->service = $service;
        $this->countryService = $countryService;
        $this->languageService = $languageService;
        $this->module = 'regions';
    }

    public function index(): View
    {
        $this->data = [
            'module' => __('Regions'),
            'title' => __('List'),
            'items' => $this->service->paginate(),
            'countries' => $this->countryService->getAll(),
            'defaultLocale' => $this->languageService->getDefaultLocale()
        ];

        return $this->render('list');
    }

    public function create(): View
    {
        $this->data = [
            'title' => __('Create Region'),
            'method' => 'POST',
            'action' => route('admin.' . $this->module . '.store'),
            'countries' => $this->countryService->getAll(),
            'languages' => $this->languageService->getActiveLanguages()
        ];

        return $this->render('form');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $item = $this->service->create($request->validated());

        return $this->redirectSuccess('admin.regions.index');
    }

    public function show(string $id): JsonResponse
    {
        $item = $this->service->getById($id);

        $this->data = [
            'id' => $item->id,
            'country' => $item->country->translations->where('locale', $this->languageService->getDefaultLocale())->first()?->name ?? $item->country->code,
            'status' => $item->status,
            'status_html' => $item->status_html,
            'translations' => $item->translations,
            'created_at_formatted' => $item->created_at->format('d.m.Y H:i:s'),
            'updated_at_formatted' => $item->updated_at->format('d.m.Y H:i:s')
        ];

        return $this->json();
    }

    public function edit(string $id): View
    {
        $item = $this->service->getById($id);

        $this->data = [
            'title' => __('Edit Region'),
            'item' => $item,
            'method' => 'PUT',
            'action' => route('admin.' . $this->module . '.update', $id),
            'countries' => $this->countryService->getAll(),
            'languages' => $this->languageService->getActiveLanguages()
        ];

        return $this->render('form');
    }

    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return $this->redirectSuccess('admin.regions.index');
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
