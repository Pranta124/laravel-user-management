<?php

namespace App\Http\Controllers\User;

use App\ApiResponse;
use App\Helpers\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\AssignPermissionRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('permission:user-list')->only(['index']);
        $this->middleware('permission:user-create')->only(['store']);
        $this->middleware('permission:user-update')->only(['update']);
        $this->middleware('permission:user-view')->only(['show']);
        $this->middleware('permission:user-delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {

        $users = $this->userRepository->list();
        $userResource = UserResource::collection($users);
        return $this->ResponseSuccess($userResource, 'User list retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        // Get the validated data
        $validated = $request->validated();

        // Hash the password before saving it
        $validated['password'] = bcrypt($validated['password']);

        // Save the user using the repository
        $user = $this->userRepository->create($validated);

        // Check if 'roles' are provided in the request data and sync roles
        if (isset($validated['roles'])) {
            // Sync roles with the user
            $user->roles()->sync($validated['roles']);
        }

        $userResource = new UserResource($user);

        // Return the created user as a response
        return $this->ResponseSuccess($userResource, 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userRepository->findById($id);
        $userResource = new UserResource($user);
        return $this->ResponseSuccess($userResource,['User retrieved successfully']);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id): JsonResponse
    {
        // Validate the request data
        $validated = $request->validated();

        // Find the user using the repository
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return $this->ResponseError('User not found', HttpStatusCode::NOT_FOUND);
        }

        // Hash the password if provided in the request
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // Remove password if not updating
        }

        // Update the user via the repository
        $updatedUser = $this->userRepository->update($id, $validated);

        // Sync roles if provided
        if ($request->has('roles')) {
            $updatedUser->roles()->attach($validated['roles']);
        }


        // Transform the updated user into a resource
        $userResource = new UserResource($updatedUser);

        // Return a success response
        return $this->ResponseSuccess($userResource, 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        // Find the user by ID
        $user = $this->userRepository->findById($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], HttpStatusCode::NOT_FOUND);
        }

        // Delete the user
        $this->userRepository->delete($id);

        // Return a success response
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function assignPermission(AssignPermissionRequest $request, int $id): JsonResponse
    {
        // Validate and retrieve the permission name from the request
        $permissions = $request->validated()['permissions'];

        // Call the repository method to assign the permission
        $success = $this->userRepository->assignPermissionsToUser($id,$permissions);

        if ($success) {
            return $this->ResponseSuccess(null, 'Permission assigned successfully.');
        } else {
            return $this->ResponseError('User or Permission not found', HttpStatusCode::NOT_FOUND);
        }
    }

}
