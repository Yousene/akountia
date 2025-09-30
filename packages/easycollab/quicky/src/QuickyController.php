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
            try {
                // Debug détaillé des données POST reçues
                \Log::info('=== DEBUT DEBUG QUICKY ===');
                \Log::info('Données POST brutes:', $request->all());
                \Log::info('projetid:', $request->input('projetid'));
                \Log::info('projet:', $request->input('projet'));
                \Log::info('Identifiants count:', count($request->input('Identifiant', [])));
                \Log::info('Identifiants:', $request->input('Identifiant', []));
                \Log::info('Labels count:', count($request->input('Label', [])));
                \Log::info('Labels:', $request->input('Label', []));
                \Log::info('Form Elements count:', count($request->input('formElement', [])));
                \Log::info('Form Elements:', $request->input('formElement', []));

                // Vérifier les champs de base requis
                if (empty($request->input('projetid'))) {
                    \Log::error('projetid est vide ou manquant');
                }
                if (empty($request->input('projet'))) {
                    \Log::error('projet est vide ou manquant');
                }
                if (empty($request->input('Identifiant'))) {
                    \Log::error('Identifiant est vide ou manquant');
                }

                \Log::info('=== FIN DEBUG POST ===');

                // Nettoyer et réorganiser les données pour la classe Quicky AVANT la validation
                $this->prepareDataForQuicky($request);

                // Validation plus flexible après nettoyage
                $request->validate([
                    'projetid' => 'required|string|max:255',
                    'projet' => 'required|string|max:255',
                    'Identifiant' => 'required|array|min:1',
                    'Label' => 'required|array',
                    'formElement' => 'required|array'
                ], [
                    'projetid.required' => 'Le nom du projet est requis.',
                    'projet.required' => 'L\'ID du projet est requis.',
                    'Identifiant.required' => 'Au moins un champ est requis.'
                ]);

                // Validation manuelle des données nettoyées
                $identifiants = $request->input('Identifiant', []);
                $labels = $request->input('Label', []);
                $formElements = $request->input('formElement', []);

                $validTypes = ['primary_key','secondary_key','text','email','number','password','url','phone','textarea','ckeditor','select','select_basic','select_multiple','select_multiple_basic','radio','checkbox','datepicker','timepicker','colorpicker','file','hidden'];

                foreach ($formElements as $index => $type) {
                    if (!in_array($type, $validTypes)) {
                        throw new \Exception("Type de champ invalide à l'index $index: $type");
                    }
                    if (empty($identifiants[$index])) {
                        throw new \Exception("Identifiant manquant à l'index $index");
                    }
                    if (empty($labels[$index])) {
                        throw new \Exception("Label manquant à l'index $index");
                    }
                }

                if ($request->has('Identifiant') && is_array($request->input('Identifiant'))) {
                    $projectName = $request->input('projetid', 'Projet sans nom');
                    $project = $this->checkIfProjectExistsInViews($request->input('projetid'));

                    if ($project) {
                        // Mise à jour d'un projet existant
                        Quicky::genCreateView(true);
                        Quicky::genUpdateView(true);
                        Quicky::genMigrationFile(true);

                        $migrateResult = Artisan::call('migrate --force');
                        Artisan::call('route:clear');

                        return redirect()->back()->with('success', "Module '$projectName' mis à jour avec succès ! ✅")
                                                ->with('info', 'Migration exécutée et routes mises à jour.');
                    } else {
                        // Création d'un nouveau projet
                        Quicky::genMigrationFile();
                        Quicky::addRoutes();
                        Quicky::genModelFile();
                        Quicky::genControllerFile();
                        Quicky::genListView();
                        Quicky::genActions();
                        Quicky::genCreateView();
                        Quicky::genUpdateView();

                        $migrateResult = Artisan::call('migrate --force');
                        Artisan::call('route:clear');

                        $filesGenerated = [
                            '📁 Modèle : app/Models/' . ucfirst($request->input('projet')) . '.php',
                            '🎮 Contrôleur : app/Http/Controllers/' . ucfirst($request->input('projet')) . 'Controller.php',
                            '👁️ Vues : resources/views/back/' . strtolower($request->input('projet')) . '/',
                            '🗄️ Migration : database/migrations/',
                            '🛣️ Routes ajoutées dans web.php'
                        ];

                        return redirect()->back()->with('success', "Module CRUD '$projectName' généré avec succès ! 🎉")
                                                ->with('files_generated', $filesGenerated)
                                                ->with('info', 'Tous les fichiers ont été créés et la base de données migrée.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Aucun champ défini. Veuillez ajouter au moins un champ à votre formulaire.');
                }
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Erreurs de validation
                \Log::warning('Erreurs de validation Quicky:', [
                    'errors' => $e->errors(),
                    'post_data' => $request->all()
                ]);

                // Afficher toutes les erreurs dans le message principal
                $allErrors = [];
                foreach ($e->errors() as $field => $errors) {
                    foreach ($errors as $error) {
                        $allErrors[] = "• " . $error;
                    }
                }
                $errorMessage = "Erreurs de validation :\n" . implode("\n", $allErrors);

                return redirect()->back()
                    ->withErrors($e->errors())
                    ->with('error', $errorMessage)
                    ->withInput();

            } catch (\Exception $e) {
                \Log::error('Erreur lors de la génération Quicky: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                    'post_data' => $request->all()
                ]);

                return redirect()->back()->with('error', 'Une erreur est survenue lors de la génération : ' . $e->getMessage())
                                        ->with('debug', 'Consultez les logs Laravel pour plus de détails.')
                                        ->withInput();
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

    /**
     * Prépare et nettoie les données pour la classe Quicky
     */
    private function prepareDataForQuicky(Request $request)
    {
        // Récupérer les données du formulaire
        $identifiants = $request->input('Identifiant', []);
        $labels = $request->input('Label', []);
        $formElements = $request->input('formElement', []);
        $visibles = $request->input('visible', []);
        $inGrids = $request->input('inGrid', []);
        $dels = $request->input('del', []);

        // Récupérer les informations sur les checkboxes non cochées
        $visibleUnchecked = $request->input('visible_unchecked', []);
        $inGridUnchecked = $request->input('inGrid_unchecked', []);

        // Nettoyer les données : supprimer les éléments vides et ceux marqués comme supprimés
        $cleanedData = [];
        $cleanedCount = 0;

        for ($i = 0; $i < count($identifiants); $i++) {
            // Ignorer les champs supprimés ou vides
            if (isset($dels[$i]) && $dels[$i] == '1') {
                continue;
            }

            if (empty($identifiants[$i]) || empty($labels[$i]) || empty($formElements[$i])) {
                continue;
            }

            $cleanedData['Identifiant'][$cleanedCount] = $identifiants[$i];
            $cleanedData['Label'][$cleanedCount] = $labels[$i];
            $cleanedData['formElement'][$cleanedCount] = $formElements[$i];

            // Définir automatiquement la taille selon le type
            $cleanedData['size'][$cleanedCount] = $this->getDefaultSizeForType($formElements[$i]);

            // Déterminer si les checkboxes sont cochées
            // Par défaut cochées, sauf si explicitement dans la liste des non cochées
            $cleanedData['visible'][$cleanedCount] = in_array($cleanedCount, $visibleUnchecked) ? 0 : 1;
            $cleanedData['inGrid'][$cleanedCount] = in_array($cleanedCount, $inGridUnchecked) ? 0 : 1;

            $cleanedData['del'][$cleanedCount] = 0;

            $cleanedCount++;
        }

        // Réorganiser $_POST pour la classe Quicky (garder la compatibilité)
        $_POST = array_merge($_POST, $cleanedData);
        $_POST['projetid'] = $request->input('projetid');
        $_POST['projet'] = $request->input('projet');
        $_POST['colNumber'] = $request->input('colNumber', 6);
        $_POST['serverSide'] = $request->input('serverSide', 0);
        $_POST['desc'] = $request->input('desc', '');

        // Nettoyer aussi les données des options (select, radio, checkbox)
        $this->cleanOptionsData($request, $cleanedCount);

        // Debug log des données nettoyées
        \Log::info('=== DEBUT NETTOYAGE QUICKY ===');
        \Log::info('Nombre de champs nettoyés:', $cleanedCount);
        \Log::info('Identifiants nettoyés:', $cleanedData['Identifiant'] ?? []);
        \Log::info('Form Elements nettoyés:', $cleanedData['formElement'] ?? []);
        \Log::info('$_POST final pour Quicky:', $_POST);
        \Log::info('=== FIN NETTOYAGE QUICKY ===');
    }

    /**
     * Nettoie les données des options (select, radio, checkbox) et clés étrangères
     */
    private function cleanOptionsData(Request $request, int $maxIndex)
    {
        // Nettoyer les données Select
        $selectCle = $request->input('Select_cle', []);
        $selectValeur = $request->input('Select_valeur', []);
        $this->cleanOptionArrays('Select_cle', 'Select_valeur', $selectCle, $selectValeur, $maxIndex);

        // Nettoyer les données Radio
        $radioCle = $request->input('Radio_cle', []);
        $radioValeur = $request->input('Radio_valeur', []);
        $this->cleanOptionArrays('Radio_cle', 'Radio_valeur', $radioCle, $radioValeur, $maxIndex);

        // Nettoyer les données Checkbox
        $checkboxCle = $request->input('Checkbox_cle', []);
        $checkboxValeur = $request->input('Checkbox_valeur', []);
        $this->cleanOptionArrays('Checkbox_cle', 'Checkbox_valeur', $checkboxCle, $checkboxValeur, $maxIndex);

        // Nettoyer les clés étrangères
        $skmodel = $request->input('skmodel', []);
        $skkey = $request->input('skkey', []);
        $skvalue = $request->input('skvalue', []);

        // Nettoyer et réindexer les clés étrangères
        $cleanedSKModel = [];
        $cleanedSKKey = [];
        $cleanedSKValue = [];

        for ($i = 0; $i < $maxIndex; $i++) {
            $cleanedSKModel[$i] = $skmodel[$i] ?? '';
            $cleanedSKKey[$i] = $skkey[$i] ?? '';
            $cleanedSKValue[$i] = $skvalue[$i] ?? '';
        }

        $_POST['skmodel'] = $cleanedSKModel;
        $_POST['skkey'] = $cleanedSKKey;
        $_POST['skvalue'] = $cleanedSKValue;

        \Log::info('Options nettoyées - Select_cle:', $_POST['Select_cle'] ?? []);
        \Log::info('Options nettoyées - Radio_cle:', $_POST['Radio_cle'] ?? []);
        \Log::info('Options nettoyées - Checkbox_cle:', $_POST['Checkbox_cle'] ?? []);
        \Log::info('Clés étrangères nettoyées:', [
            'skmodel' => $_POST['skmodel'],
            'skkey' => $_POST['skkey'],
            'skvalue' => $_POST['skvalue']
        ]);
    }

    /**
     * Nettoie un couple d'arrays d'options (clé/valeur)
     */
    private function cleanOptionArrays(string $cleKey, string $valeurKey, array $cleData, array $valeurData, int $maxIndex)
    {
        $cleanedCle = [];
        $cleanedValeur = [];

        // Initialiser les arrays avec des arrays vides pour chaque index
        for ($i = 0; $i < $maxIndex; $i++) {
            $cleanedCle[$i] = $cleData[$i] ?? [];
            $cleanedValeur[$i] = $valeurData[$i] ?? [];
        }

        $_POST[$cleKey] = $cleanedCle;
        $_POST[$valeurKey] = $cleanedValeur;
    }

    /**
     * Retourne la taille par défaut selon le type de champ
     */
    private function getDefaultSizeForType(string $type): int
    {
        return match($type) {
            'primary_key' => 0,
            'secondary_key' => 0,
            'text' => 255,
            'email' => 255,
            'password' => 255,
            'url' => 500,
            'phone' => 20,
            'textarea' => 1000,
            'ckeditor' => 0,
            'select', 'select_basic', 'select_multiple', 'select_multiple_basic' => 255,
            'radio' => 255,
            'checkbox' => 0,
            'datepicker' => 0,
            'timepicker' => 0,
            'colorpicker' => 7,
            'file' => 255,
            'hidden' => 255,
            'number' => 11,
            default => 255,
        };
    }
}
