<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Employee;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Display a paginated listing of clients.
     */
    public function index(Request $request): JsonResponse
    {
        $clients = $this->clientService->paginate(
            $request->only(['search', 'status', 'branch_id', 'funder_id']),
            $request->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(new ClientCollection($clients));
    }

    /**
     * Display the specified client.
     */
    public function show(string $uuid): JsonResponse
    {
        $client = $this->clientService->findByUuid($uuid);

        if (! $client) {
            return $this->notFoundResponse('Client not found.');
        }

        return $this->successResponse(new ClientResource($client));
    }

    /**
     * Store a newly created client.
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        $client = $this->clientService->create($request->validated());

        return $this->createdResponse(new ClientResource($client), 'Client created successfully.');
    }

    /**
     * Update the specified client.
     */
    public function update(UpdateClientRequest $request, Client $client): JsonResponse
    {
        $client = $this->clientService->update($client, $request->validated());

        return $this->successResponse(new ClientResource($client), 'Client updated successfully.');
    }

    /**
     * Remove the specified client (soft delete).
     */
    public function destroy(Client $client): JsonResponse
    {
        $this->clientService->delete($client);

        return $this->deletedResponse('Client deleted successfully.');
    }

    /**
     * Display a paginated listing of trashed clients.
     */
    public function trash(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $clients = Client::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse(new ClientCollection($clients));
    }

    /**
     * Restore a trashed client.
     */
    public function restore(string $uuid): JsonResponse
    {
        $client = $this->clientService->restore($uuid);

        if (! $client) {
            return $this->notFoundResponse('Client not found or not trashed.');
        }

        return $this->successResponse(new ClientResource($client), 'Client restored successfully.');
    }

    /**
     * Permanently delete a trashed client.
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->clientService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Client not found.');
        }

        return $this->deletedResponse('Client permanently deleted.');
    }

    /**
     * Bulk delete clients.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'exists:clients,uuid']]);

        $this->clientService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Clients deleted successfully.');
    }

    /**
     * Bulk restore clients.
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string']]);

        $this->clientService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Clients restored successfully.');
    }

    /**
     * Export clients list.
     */
    public function export(Request $request): JsonResponse
    {
        return $this->successResponse(null, 'Export functionality not implemented yet.');
    }

    /**
     * Assign an employee to a client.
     */
    public function assignEmployee(Client $client, Employee $employee, Request $request): JsonResponse
    {
        $request->validate([
            'assigned_from' => ['nullable', 'date'],
            'assigned_to' => ['nullable', 'date', 'after_or_equal:assigned_from'],
            'is_primary' => ['boolean'],
        ]);

        $this->clientService->assignEmployee($client, $employee, $request->only(['assigned_from', 'assigned_to', 'is_primary']));

        return $this->successResponse(null, 'Employee assigned to client successfully.');
    }

    /**
     * Remove an employee from a client.
     */
    public function removeEmployee(Client $client, Employee $employee): JsonResponse
    {
        $this->clientService->removeEmployee($client, $employee);

        return $this->successResponse(null, 'Employee removed from client successfully.');
    }

    /**
     * Get activities for a client.
     */
    public function activities(Client $client): JsonResponse
    {
        return $this->successResponse($client->activities()->with(['employee'])->get());
    }

    /**
     * Get assigned employees for a client.
     */
    public function employees(Client $client): JsonResponse
    {
        return $this->successResponse($client->employees()->withPivot(['assigned_from', 'assigned_to', 'is_primary'])->get());
    }
}
