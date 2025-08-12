<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\UserRepository as Repository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    public function __construct(protected Repository $repository)
    {
    }

    public function create(array $data): object
    {
        $password = Str::password(8, true, true, false);
        $data['password'] = Hash::make($password);

        $roles = $data['roles'];
        unset($data['roles']);

        $item = $this->repository->create($data);

        if ($item) {
            if ($roles) {
                $item->syncRoles($roles);
            }
        }

        return $item;
    }

    public function update(int $id, array $data): ?object
    {
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $roles = $data['roles'];
        unset($data['roles']);

        $update = $this->repository->update($id, $data);

        if ($update) {
            if ($roles) {
                $update->syncRoles($roles);
            }
        }

        return $update;
    }
}
