<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Update\OrderRequest as UpdateRequest;
use App\Services\OrderService as Service;
use App\Services\UserService;
use App\Services\PackageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends BaseController
{
    private Service $service;
    private UserService $userService;
    private PackageService $packageService;

    public function __construct(Service $service, UserService $userService, PackageService $packageService)
    {
        $this->middleware('permission:order-index|order-edit', ['only' => ['index']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);

        $this->service = $service;
        $this->userService = $userService;
        $this->packageService = $packageService;
        $this->module = 'orders';
    }

    public function index(): View
    {
        $this->data = [
            'module' => __('Orders'),
            'title' => __('List'),
            'items' => $this->service->paginate()
        ];

        return $this->render('list');
    }

    public function show(string $id): JsonResponse
    {
        $item = $this->service->getById($id);

        $this->data = [
            'id' => $item->id,
            'order_number' => $item->order_number,
            'user' => $item->user,
            'package' => $item->package,
            'amount' => $item->amount,
            'discount_amount' => $item->discount_amount,
            'total_amount' => $item->total_amount,
            'currency' => $item->currency,
            'status' => $item->status,
            'status_badge' => $item->status_badge,
            'payment_status' => $item->payment_status,
            'payment_status_badge' => $item->payment_status_badge,
            'payment_method' => $item->payment_method,
            'billing_details' => $item->billing_details,
            'notes' => $item->notes,
            'transactions' => $item->transactions,
            'completed_at' => $item->completed_at?->format('d.m.Y H:i:s'),
            'created_at_formatted' => $item->created_at->format('d.m.Y H:i:s'),
            'updated_at_formatted' => $item->updated_at->format('d.m.Y H:i:s')
        ];

        return $this->json();
    }

    public function edit(string $id): View
    {
        $item = $this->service->getById($id);

        $this->data = [
            'title' => __('Edit Order'),
            'item' => $item,
            'method' => 'PUT',
            'action' => route('admin.' . $this->module . '.update', $id),
            'users' => $this->userService->getAll(),
            'packages' => $this->packageService->getAll()
        ];

        return $this->render('form');
    }

    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return $this->redirectSuccess('admin.orders.index');
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
