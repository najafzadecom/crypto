<?php

namespace App\Http\Controllers\Admin;

use App\Services\TransactionService as Service;
use App\Services\UserService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends BaseController
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->middleware('permission:transaction-index', ['only' => ['index']]);
        $this->middleware('permission:transaction-delete', ['only' => ['destroy']]);

        $this->service = $service;
        $this->module = 'transactions';
    }

    public function index(): View
    {
        $this->data = [
            'module' => __('Transactions'),
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
            'transaction_id' => $item->transaction_id,
            'user' => $item->user,
            'order' => $item->order,
            'payment_gateway' => $item->payment_gateway,
            'gateway_transaction_id' => $item->gateway_transaction_id,
            'amount' => $item->amount,
            'currency' => $item->currency,
            'type' => $item->type,
            'type_badge' => $item->type_badge,
            'status' => $item->status,
            'status_badge' => $item->status_badge,
            'gateway_response' => $item->gateway_response,
            'failure_reason' => $item->failure_reason,
            'notes' => $item->notes,
            'processed_at' => $item->processed_at?->format('d.m.Y H:i:s'),
            'created_at_formatted' => $item->created_at->format('d.m.Y H:i:s'),
            'updated_at_formatted' => $item->updated_at->format('d.m.Y H:i:s')
        ];

        return $this->json();
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
