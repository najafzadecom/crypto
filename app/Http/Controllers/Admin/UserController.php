<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Store\UserRequest as StoreRequest;
use App\Http\Requests\Update\UserRequest as UpdateRequest;
use App\Services\RoleService;
use App\Services\UserService as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class UserController extends BaseController
{
    private Service $service;
    private RoleService $roleService;

    public function __construct(
        Service     $service,
        RoleService $roleService
    )
    {
        $this->middleware('permission:users-index|users-create|users-edit', ['only' => ['index']]);
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);

        $this->service = $service;
        $this->roleService = $roleService;
        $this->module = 'users';
    }

    public function index()
    {
        $this->data = [
            'module' => __('Users'),
            'title' => __('List'),
            'items' => $this->service->paginate()
        ];

        return $this->render('list');
    }

    public function create()
    {
        $roles = Cache::rememberForever('roles', function () {
            return $this->roleService->getAll();
        });

        $this->data = [
            'title' => __('Create'),
            'module' => __('Users'),
            'method' => 'POST',
            'roles' => $roles,
            'action' => route('admin.' . $this->module . '.store')
        ];

        return $this->render('form');
    }

    public function store(StoreRequest $request)
    {
        $item = $this->service->create($request->validated());

        return $this->redirectSuccess('admin.users.index');
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
        $roles = Cache::rememberForever('roles', function () {
            return $this->roleService->getAll();
        });

        $this->data = [
            'title' => __('Update'),
            'module' => __('Users'),
            'item' => $this->service->getById($id),
            'method' => 'PUT',
            'roles' => $roles,
            'action' => route('admin.' . $this->module . '.update', $id)
        ];

        return $this->render('form');
    }

    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return $this->redirectSuccess('admin.users.index');
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
