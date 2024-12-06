<?php

namespace App\Http\Controllers\Auth;

use App\ApiResponse;
use App\Helpers\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    use ApiResponse;
    /**
     * The AuthRepository instance.
     *
     * @var AuthRepositoryInterface
     */
    private AuthRepositoryInterface $authRepository;

    /**
     * LoginController constructor.
     *
     * @param AuthRepositoryInterface $authRepository
     */
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Handle login request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Attempt login
        $credentials = $request->only('email', 'password');
        $user = $this->authRepository->attemptLogin($credentials);

        if (!$user) {
            return $this->ResponseError('Invalid credentials', HttpStatusCode::UNAUTHORIZED);
        }
        $response = Http::post(config('app.url') . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => config('passport.client_id'),
            'client_secret' => config('passport.client_secret'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);


        return $this->ResponseSuccess(
            $response->json(),
            'Login successful',

        );

    }
}
