<?php

namespace Skycoder\Moduler\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class ModuleServiceCommand extends Command
{



    protected $signature = 'module:make-service {service} {module}';



    public function handle()
    {

        $service_name = $this->argument('service');
        $module_name = $this->argument('module');


        $module = "module/$module_name";

        $namespace = 'Module\\' . Str::studly($module_name) . '\Services';


        if (!is_dir($module)) {

            mkdir($module, 0755, true);
        }



        if (!is_dir("$module/Services")) {

            mkdir("$module/Services", 0755, true);
        }

        $arr = explode('/', $service_name);

        $recursive_directory = '';

        for ($i=0; $i < count($arr)-1; $i++) {
            $recursive_directory .= $arr[$i];

            if($i < (count($arr) - 2)) {

                $recursive_directory .= DIRECTORY_SEPARATOR;
            }
        }


        if (!is_dir("$module/Services/$recursive_directory") && $recursive_directory != '') {

            mkdir("$module/Services/$recursive_directory", 0755, true);
        }

        if($recursive_directory != '') {
            $namespace .= '\\' . $recursive_directory;
        }


        $stub = file_get_contents(__DIR__ .'/stubs/service.stub');
        $stub = str_replace('#namespace', $namespace, $stub);
        $service_name = $arr[count($arr)-1];
        $stub = str_replace('#name', $service_name, $stub);
        file_put_contents("$module/Services/$recursive_directory/$service_name.php", $stub);



        $this->info("Service $service_name created successfully.");

    }
}
