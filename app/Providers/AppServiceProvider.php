<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\BranchRepositoryInterface::class,
            \App\Repositories\Eloquent\BranchRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\FormRepositoryInterface::class,
            \App\Repositories\Eloquent\FormRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\FormSubmissionRepositoryInterface::class,
            \App\Repositories\Eloquent\FormSubmissionRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\InvoiceItemRepositoryInterface::class,
            \App\Repositories\Eloquent\InvoiceItemRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\InvoicePaymentRepositoryInterface::class,
            \App\Repositories\Eloquent\InvoicePaymentRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\InvoiceRepositoryInterface::class,
            \App\Repositories\Eloquent\InvoiceRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\LeaveRepositoryInterface::class,
            \App\Repositories\Eloquent\LeaveRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\SalaryRecordRepositoryInterface::class,
            \App\Repositories\Eloquent\SalaryRecordRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\TimesheetRepositoryInterface::class,
            \App\Repositories\Eloquent\TimesheetRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
