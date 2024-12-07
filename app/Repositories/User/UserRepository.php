<?php

namespace App\Repositories\User;

use App\Models\User;
use Spatie\Permission\Models\Permission;


class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function list()
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id): bool
    {
        $user = $this->findById($id);
        return $user->delete();
    }

    /**
     * Assign permissions to the user.
     *
     * @param int $userId
     * @param array|string $permissions
     * @return bool
     */
    public function assignPermissionsToUser(int $userId, $permissions): bool
    {
        // Find the user
        $user = User::findById($userId);

        if (!$user) {
            return false;
        }

        // Check if permissions is an array or a single permission
        $permissions = is_array($permissions) ? $permissions : [$permissions];

        // Validate that each permission exists in the permissions table
        foreach ($permissions as $permissionName) {
            $permission = Permission::findByName($permissionName);
            if (!$permission) {
                return false;
            }

            // Attach permission to user
            $user->givePermissionTo($permission);
        }

        return true;
    }

}
