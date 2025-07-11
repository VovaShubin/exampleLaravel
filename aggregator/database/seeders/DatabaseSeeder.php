<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{

    /**
     * Load seeders
     *
     * @return void
     */
    public function run(): void
    {
        $modules = config('active_modules', []);

        foreach ($modules as $module) {

            $seedersDir = base_path("app/Modules/$module/Data/Seeders");

            $module = preg_replace("/\//", '\\', $module);

            $namespace = "\\App\\Modules\\$module\\Data\\Seeders";

            if (is_dir($seedersDir)) {

                $seedersFiles = File::allFiles($seedersDir);

                foreach ($seedersFiles as $seedersFile) {

                    $seeders[] = $namespace . "\\" . preg_replace("/\.php/", "", $seedersFile->getFilename());

                }
            }
        }

        $this->call($seeders ?? []);
    }
}
