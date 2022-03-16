<?php

namespace Skycoder\Moduler\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class ModuleInstallCommand extends Command
{



    protected $signature = 'make:module {name}';



    protected $description = 'Module Creating Command';





    public function handle()
    {

        $name = $this->argument('name');


        if (!is_dir('module')) {
            mkdir('module', 0755, true);
        }

        $module = "module/$name";


        if (!is_dir($module)) {

            mkdir($module, 0755, true);
        }

        if (!is_dir("$module/Controllers")) {

            mkdir("$module/Controllers", 0755, true);
        }

        if (!is_dir("$module/Requests")) {

            mkdir("$module/Requests", 0755, true);
        }


        if (!is_dir("$module/database")) {

            mkdir("$module/database", 0755, true);
        }

        if (!is_dir("$module/database/migrations")) {

            mkdir("$module/database/migrations", 0755, true);
        }

        if (!is_dir("$module/database/seeders")) {

            mkdir("$module/database/seeders", 0755, true);
        }


        if (!is_dir("$module/Models")) {

            mkdir("$module/Models", 0755, true);
        }

        if (!is_dir("$module/Providers")) {

            mkdir("$module/Providers", 0755, true);
        }


        if (!is_dir("$module/routes")) {

            mkdir("$module/routes", 0755, true);
        }

        if (!is_dir("$module/Services")) {

            mkdir("$module/Services", 0755, true);
        }




        if (!is_dir("$module/views/partials/sidebars")) {

            mkdir("$module/views/partials/sidebars", 0755, true);
        }




        $path = $module;

        $namespace = 'Module\\' . Str::studly($name);



        // MODEL
        $stub = file_get_contents(__DIR__ .'/stubs/model.stub');
        $stub = str_replace('#namespace', $namespace, $stub);
        $stub = str_replace('#model', $name, $stub);
        file_put_contents("$path/Models/Model.php", $stub);





        $sidebar_name = str_replace('_', '-', Str::snake($name));


        // SIDEBAR
        $stub = file_get_contents(__DIR__ .'/stubs/sidebar.stub');
        file_put_contents("$path/views/partials/sidebars/$sidebar_name.blade.php", $stub);






        // WEB ROUTE
        $stub = file_get_contents(__DIR__ .'/stubs/web.stub');
        file_put_contents("$path/routes/web.php", $stub);






        // API ROUTE
        $stub = file_get_contents(__DIR__ .'/stubs/api.stub');
        file_put_contents("$path/routes/api.php", $stub);





        // SEEDER FILE
        $stub = file_get_contents(__DIR__ .'/stubs/seeders.stub');
        $stub = str_replace('#namespace', $namespace . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'Seeders', $stub);
        file_put_contents("$path/database/seeders/DatabaseSeeder.php", $stub);






        $this->info("Module Created Successfully");

    }
}
