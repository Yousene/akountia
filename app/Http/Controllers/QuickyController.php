<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyCollab\Quicky\Models\Quicky;
use Illuminate\Support\Facades\Artisan;
use App\Models\Apparence;
use App\Models\Menu;
use Illuminate\Validation\ValidationException;

/**
 * Contrôleur pour le générateur CRUD Quicky
 *
 * Gère la génération automatique de modules CRUD avec migrations,
 * modèles, contrôleurs et vues selon les bonnes pratiques Laravel.
 *
 * @package App\Http\Controllers
 * @author EasyCollab
 */
class QuickyController extends Controller
{
    /**
     * Affiche l'interface de génération CRUD et traite la soumission
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        try {
            // Récupération des données pour le layout
            $apparence = Apparence::first();
            $menus = Menu::getMenusForView();

            if ($request->isMethod('post')) {
                // Validation des données requises
                $this->validateQuickyData($request);

                // Normalisation des tableaux avant génération pour éviter les "Undefined array key"
                $this->prepareDataForQuicky($request);

                if (isset($_POST['Identifiant'])) {
                    // Vérification si le projet existe déjà
                    $project = $this->checkIfProjectExistsInViews($_POST['projetid']);

                    if ($project) {
                        // Mise à jour d'un projet existant
                        $this->updateExistingProject();
                    } else {
                        // Création d'un nouveau projet
                        $this->createNewProject();
                    }

                    // Notification de succès
                    session()->flash('success', 'Le module CRUD "' . $_POST['projetid'] . '" a été généré avec succès !');

                    return redirect()->route('quicky')
                        ->with('success', 'Module CRUD généré avec succès !');
                }
            }

            return view('back.quicky.create', compact('apparence', 'menus'));

        } catch (\Exception $e) {
            // Journaliser avec détails complets
            \Log::error('Erreur dans QuickyController::index', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            // Si erreurs de validation, renvoyer avec toutes les erreurs et le JSON reconstruit
            if ($e instanceof ValidationException) {
                $quickyJson = $this->buildJsonFromRequest($request);
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->with('error', 'Veuillez corriger les erreurs de validation ci-dessous.')
                    ->with('quicky_json', $quickyJson)
                    ->withInput();
            }

            // Laisser passer le vrai message + détails minimalistes côté UI
            $quickyJson = $this->buildJsonFromRequest($request);
            return redirect()->back()
                ->with('error', sprintf(
                    "Erreur : %s\nFichier : %s\nLigne : %d",
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                ))
                ->with('quicky_json', $quickyJson)
                ->withInput();
        }
    }

    /**
     * Vérifie si un projet existe déjà via AJAX
     *
     * @param string $projectName
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkProject($projectName)
    {
        try {
            $project = $this->checkIfProjectExistsInViews($projectName);

            return response()->json([
                'exists' => !is_null($project),
                'message' => $project ? 'Ce projet existe déjà' : 'Nom de projet disponible'
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la vérification du projet: ' . $e->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Erreur lors de la vérification'
            ], 500);
        }
    }

    /**
     * Valide les données du formulaire Quicky
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateQuickyData(Request $request)
    {
        $request->validate([
            'projetid' => 'required|string|max:255',
            'projet' => 'required|string|max:255|alpha_dash',
            'colNumber' => 'required|in:3,4,6,12',
            'Identifiant' => 'required|array|min:1',
            'Identifiant.*' => 'required|string|max:255|alpha_dash',
            'Label' => 'required|array',
            'Label.*' => 'required|string|max:255',
            'formElement' => 'required|array',
            'formElement.*' => 'required|string|in:primary_key,secondary_key,text,email,number,password,url,phone,textarea,ckeditor,select,select_basic,select_multiple,select_multiple_basic,radio,checkbox,datepicker,timepicker,colorpicker,file,multi_file,hidden',
            'Select_cle.*' => 'nullable|array',
            'Select_valeur.*' => 'nullable|array',
            'Radio_cle.*' => 'nullable|array',
            'Radio_valeur.*' => 'nullable|array',
            'Checkbox_cle.*' => 'nullable|array',
            'Checkbox_valeur.*' => 'nullable|array',
        ], [
            'projetid.required' => 'Le nom du projet est requis',
            'projet.required' => 'L\'ID du projet est requis',
            'projet.alpha_dash' => 'L\'ID du projet ne peut contenir que des lettres, chiffres, tirets et underscores',
            'Identifiant.required' => 'Au moins un champ est requis',
            'Identifiant.*.alpha_dash' => 'Les identifiants ne peuvent contenir que des lettres, chiffres, tirets et underscores',
        ]);
    }

    /**
     * Prépare et nettoie les données pour la génération Quicky (évite les index manquants)
     */
    private function prepareDataForQuicky(Request $request): void
    {
        $identifiants = $request->input('Identifiant', []);
        $labels = $request->input('Label', []);
        $types = $request->input('formElement', []);
        $dels = $request->input('del', []);

        $clean = [
            'Identifiant' => [],
            'Label' => [],
            'formElement' => [],
            'del' => [],
            'visible' => [],
            'inGrid' => []
        ];

        $count = max(count($identifiants), count($labels), count($types));
        for ($i = 0; $i < $count; $i++) {
            if (isset($dels[$i]) && (string)$dels[$i] === '1') {
                continue;
            }
            if (empty($identifiants[$i]) || empty($labels[$i]) || empty($types[$i])) {
                continue;
            }

            $clean['Identifiant'][] = $identifiants[$i];
            $clean['Label'][] = $labels[$i];
            $clean['formElement'][] = $types[$i];
            $clean['del'][] = 0;
        }

        // Réinjecter dans $_POST pour compat compatibilité avec Quicky::
        foreach ($clean as $k => $v) {
            $_POST[$k] = $v;
        }

        // Reconstruire visible/inGrid alignés par index (par défaut 1 sauf explicitement décoché)
        $visibleUnchecked = $request->input('visible_unchecked', []);
        $inGridUnchecked = $request->input('inGrid_unchecked', []);
        $_POST['visible'] = [];
        $_POST['inGrid'] = [];
        for ($i = 0; $i < count($_POST['Identifiant']); $i++) {
            $_POST['visible'][$i] = in_array($i, $visibleUnchecked) ? 0 : 1;
            $_POST['inGrid'][$i] = in_array($i, $inGridUnchecked) ? 0 : 1;
        }

        // Normaliser aussi les structures des options pour éviter les clés manquantes
        $max = count($clean['Identifiant']);
        foreach (['Select_cle','Select_valeur','Radio_cle','Radio_valeur','Checkbox_cle','Checkbox_valeur'] as $optKey) {
            $arr = $request->input($optKey, []);
            $normalized = [];
            for ($i = 0; $i < $max; $i++) {
                $val = $arr[$i] ?? [];
                // Force array: si c'est une string ou null, on la transforme en array
                $normalized[$i] = is_array($val) ? $val : (strlen((string)$val) ? [(string)$val] : []);
            }
            $_POST[$optKey] = $normalized;
        }

        foreach (['skmodel','skkey','skvalue'] as $fkKey) {
            $arr = $request->input($fkKey, []);
            $normalized = [];
            for ($i = 0; $i < $max; $i++) {
                $normalized[$i] = $arr[$i] ?? '';
            }
            $_POST[$fkKey] = $normalized;
        }

        // Merge les données normalisées dans la Request pour que buildJsonFromRequest voit les bonnes valeurs
        $request->merge($_POST);
    }

    /**
     * Construit le JSON compatible importFromJSON depuis la requête
     */
    private function buildJsonFromRequest(Request $request): string
    {
        $fields = [];
        $identifiants = $request->input('Identifiant', []);
        $labels = $request->input('Label', []);
        $types = $request->input('formElement', []);
        $visibles = $request->input('visible', []);
        $inGrids = $request->input('inGrid', []);
        $selectCle = $request->input('Select_cle', []);
        $selectVal = $request->input('Select_valeur', []);
        $radioCle = $request->input('Radio_cle', []);
        $radioVal = $request->input('Radio_valeur', []);
        $checkboxCle = $request->input('Checkbox_cle', []);
        $checkboxVal = $request->input('Checkbox_valeur', []);
        $skmodel = $request->input('skmodel', []);
        $skkey = $request->input('skkey', []);
        $skvalue = $request->input('skvalue', []);

        $count = max(count($identifiants), count($labels), count($types));
        for ($i = 0; $i < $count; $i++) {
            if (empty($identifiants[$i]) || empty($labels[$i]) || empty($types[$i])) {
                continue;
            }
            $field = [
                'identifiant' => (string)$identifiants[$i],
                'label' => (string)$labels[$i],
                'type' => (string)$types[$i],
                'required' => isset($visibles[$i]) && (string)$visibles[$i] === '1',
                'inGrid' => isset($inGrids[$i]) && (string)$inGrids[$i] === '1',
            ];

            // Options
            if (in_array($field['type'], ['select','select_basic','select_multiple','select_multiple_basic','radio','checkbox'])) {
                $pairs = [];
                $keys = [];
                $vals = [];
                if (in_array($field['type'], ['select','select_basic','select_multiple','select_multiple_basic'])) {
                    $keys = (array)($selectCle[$i] ?? []);
                    $vals = (array)($selectVal[$i] ?? []);
                } elseif ($field['type'] === 'radio') {
                    $keys = (array)($radioCle[$i] ?? []);
                    $vals = (array)($radioVal[$i] ?? []);
                } elseif ($field['type'] === 'checkbox') {
                    $keys = (array)($checkboxCle[$i] ?? []);
                    $vals = (array)($checkboxVal[$i] ?? []);
                }
                foreach ($keys as $k => $v) {
                    $vv = $vals[$k] ?? null;
                    if ($v !== null && $vv !== null && $v !== '' && $vv !== '') {
                        $pairs[] = ['cle' => (string)$v, 'valeur' => (string)$vv];
                    }
                }
                if (!empty($pairs)) {
                    $field['options'] = $pairs;
                }
            }

            // Foreign key
            if ($field['type'] === 'secondary_key') {
                $field['foreignKey'] = [
                    'model' => (string)($skmodel[$i] ?? ''),
                    'key' => (string)($skkey[$i] ?? 'id'),
                    'value' => (string)($skvalue[$i] ?? ''),
                ];
            }

            $fields[] = $field;
        }

        return json_encode($fields, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Met à jour un projet existant
     *
     * @throws \Exception
     */
    private function updateExistingProject()
    {
        try {
            Quicky::genCreateView(true);
            Quicky::genUpdateView(true);
            Quicky::genMigrationFile(true);

            // Exécution des migrations avec gestion d'erreur
            $this->runMigrations();

            \Log::info('Projet mis à jour avec succès: ' . $_POST['projetid']);

        } catch (\Exception $e) {
            \Log::error('updateExistingProject', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // <- renvoyer l'exception originale
        }
    }

    /**
     * Crée un nouveau projet complet
     *
     * @throws \Exception
     */
    private function createNewProject()
    {
        try {
            // Génération des fichiers dans l'ordre
            Quicky::genMigrationFile();
            Quicky::addRoutes();
            Quicky::genModelFile();
            Quicky::genControllerFile();
            Quicky::genListView();
            Quicky::genActions();
            Quicky::genCreateView();
            Quicky::genUpdateView();

            // Exécution des migrations
            $this->runMigrations();

            \Log::info('Nouveau projet créé avec succès: ' . $_POST['projetid']);

        } catch (\Exception $e) {
            \Log::error('createNewProject', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // <- renvoyer l'exception originale
        }
    }

    /**
     * Exécute les migrations avec gestion d'erreur
     *
     * @throws \Exception
     */
    private function runMigrations()
    {
        try {
            // Effacement du cache des routes
            Artisan::call('route:clear');

            // Exécution des migrations
            $migrationOutput = Artisan::call('migrate', ['--force' => true]);

            if ($migrationOutput !== 0) {
                throw new \Exception('Erreur lors de l\'exécution des migrations');
            }

            \Log::info('Migrations exécutées avec succès');

        } catch (\Exception $e) {
            \Log::error('Erreur lors des migrations: ' . $e->getMessage());
            throw new \Exception('Erreur lors des migrations: ' . $e->getMessage());
        }
    }

    /**
     * Récupère la liste des tables existantes dans la base de données
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTables()
    {
        try {
            $tables = \DB::select('SHOW TABLES');
            $tableNames = [];

            // Extraire les noms de tables (la clé varie selon le driver de base de données)
            foreach ($tables as $table) {
                $tableArray = (array) $table;
                $tableNames[] = array_values($tableArray)[0];
            }

            // Filtrer les tables système et ne garder que les tables métier
            $filteredTables = array_filter($tableNames, function ($table) {
                return !in_array($table, [
                    'migrations', 'password_resets', 'failed_jobs',
                    'personal_access_tokens', 'sessions', 'cache',
                    'cache_locks', 'jobs', 'job_batches'
                ]);
            });

            return response()->json([
                'success' => true,
                'tables' => array_values($filteredTables)
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des tables: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des tables'
            ], 500);
        }
    }

    /**
     * Récupère les colonnes d'une table spécifique
     *
     * @param string $tableName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableColumns($tableName)
    {
        try {
            // Validation du nom de table pour éviter les injections SQL
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $tableName)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nom de table invalide'
                ], 400);
            }

            $columns = \DB::select("DESCRIBE `{$tableName}`");
            $columnData = [];

            foreach ($columns as $column) {
                $columnData[] = [
                    'name' => $column->Field,
                    'type' => $column->Type,
                    'null' => $column->Null,
                    'key' => $column->Key,
                    'default' => $column->Default,
                    'extra' => $column->Extra
                ];
            }

            return response()->json([
                'success' => true,
                'columns' => $columnData
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des colonnes: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des colonnes'
            ], 500);
        }
    }

    /**
     * Vérifie si un projet existe dans le dossier views
     *
     * @param string $projectName
     * @return bool
     */
    private function checkIfProjectExistsInViews($projectName)
    {
        // Chemin vers le dossier des vues
        $viewsDirectory = resource_path('views');

        // Conversion en minuscules pour comparaison insensible à la casse
        $projectNameLowercase = strtolower($projectName);

        // Construction du chemin vers le dossier du projet
        $projectFolder = $viewsDirectory . '/back/' . $projectNameLowercase;

        // Vérification de l'existence du dossier
        return is_dir($projectFolder);
    }
}
