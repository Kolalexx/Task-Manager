<?php

namespace App\Providers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Policies\LabelPolicy;
use App\Policies\TaskPolicy;
use App\Policies\TaskStatusPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(TaskStatus::class, TaskStatusPolicy::class);
        Gate::policy(Label::class, LabelPolicy::class);

        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
