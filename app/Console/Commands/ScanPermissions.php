<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Permission;

class ScanPermissions extends Command
{
    protected $signature = 'scan:permissions';
    protected $description = 'Scan the project for permissions and store them in the database';

    public function handle()
    {
        $viewPath = resource_path('views');
        $filePaths = File::allFiles($viewPath);

        $this->output->progressStart(count($filePaths));

        $permissionsFound = [];

        foreach ($filePaths as $filePath) {
            $content = File::get($filePath);

            preg_match_all('/@can\(\'(.*?)\'\)/', $content, $matches);

            if (isset($matches[1])) {
                foreach ($matches[1] as $permissionName) {
                    Permission::firstOrCreate(['name' => $permissionName]);
                    $permissionsFound[] = $permissionName;
                }
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();

        // Remove permissions not found in view files
        $permissionsInDb = Permission::all('name')->pluck('name')->toArray();

        $permissionsToRemove = array_diff($permissionsInDb, $permissionsFound);

        foreach ($permissionsToRemove as $permissionName) {
            Permission::where('name', $permissionName)->delete();
        }
    }
}
