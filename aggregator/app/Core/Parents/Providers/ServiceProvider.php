<?php

namespace App\Core\Parents\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as LaravelAppServiceProvider;
use Illuminate\Support\Str;

abstract class ServiceProvider extends LaravelAppServiceProvider
{

    /**
     * @var array
     */
    protected array $policies = [];

    /**
     * @var string
     */
    protected string $containerPath;

    /**
     * @param $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $class = static::class;

        $split = preg_split('/\\\/', $class);

        $container = array_slice($split, 2, (count($split) - 1 - 2));

        $this->containerPath = implode(DIRECTORY_SEPARATOR, $container);

        $this->addViewsLocation();
    }

    /**
     * @return void
     */
    public function register(): void
    {
        parent::register();

        //Init active modules in config
        $modules = config('active_modules', []);

        if (!in_array($this->containerPath, $modules)) {
            config()->push('active_modules', $this->containerPath);
        }

        $this->booting(function () {
            $this->registerPolicies();
        });
    }


    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadConfigs();

        $this->loadMigrations();
    }

    /**
     * @return void
     */
    public function registerPolicies(): void
    {
        foreach ($this->policies() as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    /**
     * @return array
     */
    public function policies(): array
    {
        return $this->policies;
    }

    /**
     * @param string $dir
     * @param string $prefix
     * @param array|string|null $middleware
     * @return void
     */
    protected function loadRoutes(string $dir, string $prefix = "", array|string $middleware = null): void
    {
        $routesPath = base_path("app/Modules/{$this->containerPath}/UI/$dir");

        if (is_dir($routesPath)) {

            $files = File::allFiles($routesPath);

            foreach ($files as $file) {

                if (empty($middleware)) {

                    Route::prefix($prefix)->group($file->getRealPath());
                }

                Route::middleware($middleware)->prefix($prefix)->group($file->getRealPath());
            }

        }
    }

    /**
     * @return void
     */
    protected function loadCommands(): void
    {
        $commandsPath = base_path("app/Modules/{$this->containerPath}/UI/CLI/Commands");

        $classes = [];

        if (is_dir($commandsPath)) {

            $files = File::allFiles($commandsPath);

            foreach ($files as $file) {

                $class = "App\\" . str_replace(
                        ['/', '.php'],
                        ['\\', ''],
                        Str::after($file->getRealPath(), realpath(app_path()) . DIRECTORY_SEPARATOR)
                    );

                $classes[] = $class;

            }

        }

        $this->commands($classes);
    }

    protected function loadAPIRoutes($version = "V1"): void
    {
        $this->loadRoutes("API/$version/Routes", "api", ['api', 'throttle:60']);
    }

    protected function loadWEBRoutes(): void
    {
        $this->loadRoutes("WEB/Routes", "", ['web']);
    }

    /**
     * @return void
     */
    protected function loadMigrations(): void
    {
        $migrationsPath = base_path("app/Modules/{$this->containerPath}/Data/Migrations");

        if (is_dir($migrationsPath)) {

            $this->loadMigrationsFrom($migrationsPath);

        }
    }

    /**
     * @return void
     */
    protected function loadConfigs(): void
    {
        $configsPath = base_path("app/Modules/{$this->containerPath}/Configs");

        if (is_dir($configsPath)) {

            $this->app->configPath($configsPath);

            $configFiles = File::allFiles($configsPath);

            foreach ($configFiles as $configFile) {

                $configName = preg_replace('/\.php/', "", $configFile->getFilename());

                config()->set($configName, require($configFile->getRealPath()));

            }
        }
    }

    protected function addViewsLocation(): void
    {
        $viewsPath = base_path("app/Modules/{$this->containerPath}/UI/WEB/Views");

        if (is_dir($viewsPath)) {

            View::addLocation($viewsPath);
        }
    }


}
