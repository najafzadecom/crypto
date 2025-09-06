<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Models\Permission;
use App\Repositories\RoleRepository as Repository;
use Illuminate\Database\Eloquent\Collection;

class RoleService extends BaseService
{
    public function __construct(protected Repository $repository)
    {
    }

    public function create(array $data): object
    {
        $permissionIds = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role = $this->repository->create($data);

        if (!empty($permissionIds)) {
            $permissions = Permission::query()->whereIn('id', $permissionIds)->get();
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function update(int $id, array $data): ?object
    {
        $permissionIds = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role = $this->repository->update($id, $data);

        if ($role && !empty($permissionIds)) {
            $permissions = Permission::query()->whereIn('id', $permissionIds)->get();
            $role->syncPermissions($permissions);
        } elseif ($role) {
            $role->syncPermissions([]);
        }

        return $role;
    }

    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    public function getActives(): Collection
    {
        return $this->repository->getModel()
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }
}
