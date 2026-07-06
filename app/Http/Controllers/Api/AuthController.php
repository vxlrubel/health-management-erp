<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * Login
     *
     * Authenticate a user and return an API token along with user data.
     *
     * @unauthenticated
     *
     * @response array{success: bool, message: string, data: array{token: string, user: UserResource}}
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return $this->successResponse([
            'token' => $result['token'],
            'user' => new UserResource($result['user']),
        ], 'Login successful.');
    }

    /**
     * Logout
     *
     * Revoke the current API token.
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->successResponse(null, 'Logged out successfully.');
    }

    /**
     * Forgot Password
     *
     * Send a password reset link to the given email.
     *
     * @unauthenticated
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $message = $this->authService->forgotPassword($request->validated());

        return $this->successResponse(null, $message);
    }

    /**
     * Reset Password
     *
     * Reset the user's password using a valid token.
     *
     * @unauthenticated
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $message = $this->authService->resetPassword($request->validated());

        return $this->successResponse(null, $message);
    }

    /**
     * Profile
     *
     * Get the authenticated user's profile.
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $this->authService->getProfile($request->user());

        return $this->successResponse(new UserResource($user), 'Profile retrieved successfully.');
    }

    /**
     * Update Profile
     *
     * Update the authenticated user's profile.
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->authService->updateProfile($request->user(), $request->validated());

        return $this->successResponse(new UserResource($user), 'Profile updated successfully.');
    }

    /**
     * Change Password
     *
     * Change the authenticated user's password.
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $this->authService->changePassword(
            $request->user(),
            $request->input('current_password'),
            $request->input('password')
        );

        return $this->successResponse(null, 'Password changed successfully.');
    }
}
