<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\RoleRepository as Repository;
use App\Models\Permission;

class RoleService extends BaseService
{
    public function __construct(protected Repository $repository) {}

    public function create(array $data): object
    {
        $permissionIds = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role = $this->repository->create($data);
        
        if (!empty($permissionIds)) {
            $permissions = Permission::whereIn('id', $permissionIds)->get();
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
            $permissions = Permission::whereIn('id', $permissionIds)->get();
            $role->syncPermissions($permissions);
        } elseif ($role) {
            // Əgər permission-lar boşdursa, bütün permission-ları sil
            $role->syncPermissions([]);
        }

        return $role;
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }
}
