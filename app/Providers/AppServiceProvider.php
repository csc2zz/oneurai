<?php

namespace App\Providers;

use App\Models\AiModel;
use App\Models\Dataset;
use App\Models\DatasetFile;
use App\Models\ModelFile;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\User;
use App\Observers\AiModelObserver;
use App\Observers\ContributionObserver;
use App\Observers\DatasetObserver;
use App\Observers\DatasetFileObserver;
use App\Observers\ModelFileObserver;
use App\Observers\ProjectFileObserver;
use App\Observers\ProjectObserver;
use App\Observers\UserObserver;
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
        Project::observe(ProjectObserver::class);
        Dataset::observe(DatasetObserver::class);
        DatasetFile::observe(DatasetFileObserver::class);
        User::observe(UserObserver::class);
        ProjectFile::observe(ProjectFileObserver::class);
        AiModel::observe(AiModelObserver::class);
        ModelFile::observe(ModelFileObserver::class);
    }
}
