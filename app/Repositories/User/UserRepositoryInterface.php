<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * List all users.
     *
     * @return array
     */
    public function list();

    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * Create a new user.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * Delete a user.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    public function assignPermissionsToUser(int $userId, string $permissionName): bool;

}
