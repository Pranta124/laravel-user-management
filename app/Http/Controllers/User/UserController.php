<?php

namespace App\Http\Controllers\User;

use App\ApiResponse;
use App\Http\Controllers\Controller;
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
        $this->middleware('permission:user-edit')->only(['update']);
        $this->middleware('permission:user-view')->only(['show']);
        $this->middleware('permission:user-delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
