<?php

namespace App\Services\Finance;

use App\Models\Form;
use App\Models\FormSubmission;
use App\Repositories\Contracts\FormRepositoryInterface;
use App\Repositories\Contracts\FormSubmissionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class FormService
{
    public function __construct(
        protected FormRepositoryInterface $repository,
        protected FormSubmissionRepositoryInterface $submissionRepository,
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findByUuid(string $uuid): ?Form
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data): Form
    {
        return $this->repository->create($data);
    }

    public function update(Form $form, array $data): Form
    {
        return $this->repository->update($form, $data);
    }

    public function softDelete(Form $form): bool
    {
        return $this->repository->softDelete($form);
    }

    public function restore(string $uuid): ?Form
    {
        return $this->repository->restore($uuid);
    }

    public function forceDelete(string $uuid): bool
    {
        return $this->repository->forceDelete($uuid);
    }

    public function bulkDelete(array $uuids): bool
    {
        return $this->repository->bulkDelete($uuids);
    }

    public function bulkRestore(array $uuids): bool
    {
        return $this->repository->bulkRestore($uuids);
    }

    public function publish(string $uuid): ?Form
    {
        $form = $this->repository->findByUuid($uuid);
        if (! $form) {
            return null;
        }

        $form->publish();

        return $form->fresh();
    }

    public function archive(string $uuid): ?Form
    {
        $form = $this->repository->findByUuid($uuid);
        if (! $form) {
            return null;
        }

        $form->archive();

        return $form->fresh();
    }

    public function assign(string $formUuid, array $data): ?FormSubmission
    {
        $form = $this->repository->findByUuid($formUuid);
        if (! $form) {
            return null;
        }

        return $this->submissionRepository->create([
            'form_id' => $form->id,
            'submitted_by' => Auth::id(),
            'subject_type' => $data['subject_type'],
            'subject_id' => $data['subject_id'],
            'answers_json' => $data['answers_json'] ?? [],
            'status' => $data['status'] ?? null,
            'submitted_at' => now(),
        ]);
    }
}
