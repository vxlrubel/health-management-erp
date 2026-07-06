<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * List Users
     *
     * Get a paginated list of users.
     *
     * @queryParam page int Page number. Example: 1
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam search string Search term for name, email or phone. Example: john
     * @queryParam status string Filter by status. Example: active
     * @queryParam branch_id int Filter by branch ID. Example: 1
     * @queryParam role_id int Filter by role ID. Example: 1
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->paginate(
            $request->only(['search', 'status', 'branch_id', 'role_id']),
            $request->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(new UserCollection($users));
    }

    /**
     * Create User
     *
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());

        return $this->createdResponse(new UserResource($user), 'User created successfully.');
    }

    /**
     * Show User
     *
     * Display the specified user by UUID.
     */
    public function show(string $uuid): JsonResponse
    {
        $user = $this->userService->findByUuid($uuid);

        if (! $user) {
            return $this->notFoundResponse('User not found.');
        }

        return $this->successResponse(new UserResource($user), 'User retrieved successfully.');
    }

    /**
     * Update User
     *
     * Update the specified user by UUID.
     */
    public function update(UpdateUserRequest $request, string $uuid): JsonResponse
    {
        $user = $this->userService->findByUuid($uuid);

        if (! $user) {
            return $this->notFoundResponse('User not found.');
        }

        $user = $this->userService->update($user, $request->validated());

        return $this->successResponse(new UserResource($user), 'User updated successfully.');
    }

    /**
     * Delete User
     *
     * Soft delete the specified user by UUID.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $user = $this->userService->findByUuid($uuid);

        if (! $user) {
            return $this->notFoundResponse('User not found.');
        }

        $this->userService->softDelete($user);

        return $this->deletedResponse('User deleted successfully.');
    }

    /**
     * Trashed Users
     *
     * Get a paginated list of soft-deleted users.
     *
     * @queryParam page int Page number. Example: 1
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam search string Search term for name or email. Example: john
     */
    public function trash(Request $request): JsonResponse
    {
        $users = $this->userService->trash(
            $request->only(['search']),
            $request->only(['per_page'])
        );

        return $this->paginatedResponse(new UserCollection($users));
    }

    /**
     * Restore User
     *
     * Restore the specified soft-deleted user by UUID.
     */
    public function restore(string $uuid): JsonResponse
    {
        $user = $this->userService->restore($uuid);

        if (! $user) {
            return $this->notFoundResponse('User not found or already restored.');
        }

        return $this->successResponse(new UserResource($user), 'User restored successfully.');
    }

    /**
     * Force Delete User
     *
     * Permanently delete the specified user by UUID.
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->userService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('User not found.');
        }

        return $this->deletedResponse('User permanently deleted.');
    }

    /**
     * Bulk Delete Users
     *
     * Soft delete multiple users by UUIDs.
     *
     * @bodyParam uuids array required Array of user UUIDs to delete. Example: ["uuid-1", "uuid-2"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'uuids' => ['required', 'array'],
            'uuids.*' => ['required', 'string'],
        ]);

        $this->userService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Users deleted successfully.');
    }

    /**
     * Bulk Restore Users
     *
     * Restore multiple soft-deleted users by UUIDs.
     *
     * @bodyParam uuids array required Array of user UUIDs to restore. Example: ["uuid-1", "uuid-2"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate([
            'uuids' => ['required', 'array'],
            'uuids.*' => ['required', 'string'],
        ]);

        $this->userService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Users restored successfully.');
    }

    /**
     * Export Users
     *
     * Export users data based on filters.
     *
     * @queryParam status string Filter by status. Example: active
     * @queryParam branch_id int Filter by branch ID. Example: 1
     */
    public function export(Request $request): JsonResponse
    {
        $users = $this->userService->export($request->only(['status', 'branch_id']));

        return $this->successResponse(UserResource::collection($users), 'Users exported successfully.');
    }
}
