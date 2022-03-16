<?php

namespace Skycoder\Moduler;

use Illuminate\Support\ServiceProvider;
use Skycoder\Moduler\Commands\ModuleInstallCommand;
use Skycoder\Moduler\Commands\ModuleServiceCommand;
use Skycoder\Moduler\Commands\ModuleTraitCommand;

class LaravelModuleManagerServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {


        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            
            $this->commands([
                ModuleInstallCommand::class,
                ModuleTraitCommand::class,
                ModuleServiceCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
