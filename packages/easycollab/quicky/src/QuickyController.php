<?php

namespace EasyCollab\Quicky;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyCollab\Quicky\Models\Quicky;
use Illuminate\Support\Facades\Artisan;

class QuickyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            if (isset($_POST['Identifiant'])) {
                // $project = Quickyproject::all()->where('deleted', "0")->where('name', $_POST['projetid'])->first();
                $project = $this->checkIfProjectExistsInViews($_POST['projetid']);
                if ($project) {
                    Quicky::genCreateView(true);
                    Quicky::genUpdateView(true);
                    Quicky::genMigrationFile(true);
                    Artisan::call('migrate --force');
                    Artisan::call('route:clear');
                } else {
                    //\DB::statement(Quicky::getSql());
                    Quicky::genMigrationFile();
                    Quicky::addRoutes();
                    Quicky::genModelFile();
                    Quicky::genControllerFile();
                    Quicky::genListView();
                    Quicky::genActions();
                    Quicky::genCreateView();
                    Quicky::genUpdateView();
                    // Quicky::addProjectToList($_POST['projetid']);
                    Artisan::call('migrate --force');
                    Artisan::call('route:clear');
                }
            }
        }
        return view('easycollab::create');
    }

    public function checkProject($projectName)
    {
        $project = $this->checkIfProjectExistsInViews($projectName);
        return response()->json(['exists' => !is_null($project)]);
    }


    private function checkIfProjectExistsInViews($projectName)
    {
        // Define the views directory.
        $viewsDirectory = resource_path('views');

        // Convert the project name to lowercase for case-insensitive comparison.
        $projectNameLowercase = strtolower($projectName);

        // Construct the path to the project folder.
        $projectFolder = $viewsDirectory . '/back/' . $projectNameLowercase;
        // Check if the project folder exists.
        return is_dir($projectFolder);
    }
}
