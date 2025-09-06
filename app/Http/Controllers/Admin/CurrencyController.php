<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Store\CurrencyRequest as StoreRequest;
use App\Http\Requests\Update\CurrencyRequest as UpdateRequest;
use App\Services\CurrencyService as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CurrencyController extends BaseController
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->middleware('permission:currency-index|currency-create|currency-edit', ['only' => ['index']]);
        $this->middleware('permission:currency-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:currency-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:currency-delete', ['only' => ['destroy']]);

        $this->service = $service;
        $this->module = 'currencies';
    }

    public function index(): View
    {
        $this->data = [
            'module' => __('Currencies'),
            'title' => __('List'),
            'items' => $this->service->paginate(),
        ];

        return $this->render('list');
    }

    public function create(): View
    {
        $this->data = [
            'title' => __('Create Currency'),
            'method' => 'POST',
            'action' => route('admin.' . $this->module . '.store'),
        ];

        return $this->render('form');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $item = $this->service->create($request->validated());

        return $this->redirectSuccess('admin.currencies.index');
    }

    public function show(string $id): JsonResponse
    {
        $item = $this->service->getById($id);

        $this->data = [
            'id' => $item->id,
            'name' => $item->name,
            'code' => $item->code,
            'symbol' => $item->symbol,
            'rate' => $item->rate,
            'is_default' => $item->is_default,
            'status' => $item->status,
            'status_html' => $item->status_html,
            'created_at_formatted' => $item->created_at->format('d.m.Y H:i:s'),
            'updated_at_formatted' => $item->updated_at->format('d.m.Y H:i:s')
        ];

        return $this->json();
    }

    public function edit(string $id): View
    {
        $item = $this->service->getById($id);

        $this->data = [
            'title' => __('Edit Currency'),
            'item' => $item,
            'method' => 'PUT',
            'action' => route('admin.' . $this->module . '.update', $id),
        ];

        return $this->render('form');
    }

    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return $this->redirectSuccess('admin.currencies.index');
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
