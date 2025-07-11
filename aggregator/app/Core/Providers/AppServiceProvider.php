<?php

namespace App\Core\Providers;


class AppServiceProvider extends LaravelAppServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadCoreMigrations();

        $this->app->register(TestServiceProvider::class);

        //$this->app->register(ExampleContainerServiceProvider::class);

        if (app()->isLocal()) {

            $this->app->register(ExampleContainerServiceProvider::class);

            if (env('LOG_DB_QUERIES', 'false')) {
                DB::listen(function (QueryExecuted $query) {
                    Log::info('SQL: ' . $query->sql);
                    Log::info('Bindings: ' . print_r($query->bindings, true));
                    Log::info('time: ' . $query->time); //milliseconds
                });
            }
        }

                Cache::macro('getFileCacheTTL', function (string $key): ?int {
            $fs = new class extends FileStore {
                public function __construct()
                {
                    parent::__construct(\App::get('files'), config('cache.stores.file.path'));
                }

                public function getTTL(string $key): ?int
                {
                    return $this->getPayload($key)['time'] ?? null;
                }
            };
            return $fs->getTTL($key);
        });
    }

    /**
     * @return void
     */
    private function loadCoreMigrations(): void
    {
        $migrationsPath = base_path("app/Core/Data/Migrations");

        if (is_dir($migrationsPath)) {

            $this->loadMigrationsFrom($migrationsPath);

        }
    }
}
