<?php

namespace Skycoder\Moduler\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class ModuleTraitCommand extends Command
{



    protected $signature = 'module:make-trait {trait} {module}';



    public function handle()
    {

        $trait_name = $this->argument('trait');
        $module_name = $this->argument('module');


        $module = "module/$module_name";

        $namespace = 'Module\\' . Str::studly($module_name) . '\Traits';


        if (!is_dir($module)) {

            mkdir($module, 0755, true);
        }



        if (!is_dir("$module/Traits")) {

            mkdir("$module/Traits", 0755, true);
        }


        $arr = explode('/', $trait_name);

        $recursive_directory = '';

        for ($i=0; $i < count($arr)-1; $i++) {
            $recursive_directory .= $arr[$i];

            if($i < (count($arr) - 2)) {

                $recursive_directory .= DIRECTORY_SEPARATOR;
            }
        }


        if (!is_dir("$module/Traits/$recursive_directory") && $recursive_directory != '') {

            mkdir("$module/Traits/$recursive_directory", 0755, true);
        }

        if($recursive_directory != '') {
            $namespace .= '\\' . $recursive_directory;
        }


        $stub = file_get_contents(__DIR__ .'/stubs/trait.stub');
        $stub = str_replace('#namespace', $namespace, $stub);
        $trait_name = $arr[count($arr)-1];
        $stub = str_replace('#name', $trait_name, $stub);
        file_put_contents("$module/Traits/$recursive_directory/$trait_name.php", $stub);


        $this->info("Trait $trait_name created successfully.");

    }
}
