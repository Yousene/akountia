@extends('layouts.back')

@section('css')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <style>
        :root {
            --quicky-primary: #00556e;
            --quicky-primary-hover: #004a61;
            --quicky-primary-light: #e5f0f3;
            --quicky-primary-opacity-15: rgba(0, 85, 110, 0.15);
            --quicky-primary-opacity-8: rgba(0, 85, 110, 0.08);
            --quicky-secondary: #46aac6;
            --quicky-text-primary: #00556e;
            --quicky-text-secondary: #697a8d;
            --quicky-text-muted: #a5afbb;
        }

        .quicky-form-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 15px var(--quicky-primary-opacity-8);
            padding: 2rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--quicky-primary-light);
        }

        .form-field-container {
            background: var(--quicky-primary-light);
            border: 1px solid var(--quicky-primary-opacity-15);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            transition: all 0.3s ease;
            animation: slideInUp 0.5s ease;
        }

        .form-field-container:hover {
            border-color: var(--quicky-secondary);
            box-shadow: 0 4px 12px var(--quicky-primary-opacity-8);
        }

        .field-controls {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .field-controls>* {
            flex: 1;
            min-width: 120px;
        }

        .delete-field {
            color: #ff3e1d;
            cursor: pointer;
            font-size: 1.2rem;
            flex: none;
            width: auto;
            transition: all 0.3s ease;
        }

        .delete-field:hover {
            color: #e6391a;
            transform: scale(1.1);
        }

        .field-type-options {
            margin-top: 1rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            border: 1px solid var(--quicky-primary-opacity-15);
            backdrop-filter: blur(5px);
        }

        .option-item {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            align-items: center;
        }

        .btn-add-field {
            background: linear-gradient(135deg, var(--quicky-primary) 0%, var(--quicky-secondary) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--quicky-primary-opacity-15);
        }

        .btn-add-field:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px var(--quicky-primary-opacity-15);
            color: white;
            background: linear-gradient(135deg, var(--quicky-primary-hover) 0%, var(--quicky-secondary) 100%);
        }

        .project-header {
            background: linear-gradient(135deg, var(--quicky-primary) 0%, var(--quicky-secondary) 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px 12px 0 0;
            /* margin: -2rem -2rem 2rem -2rem; */
            position: relative;
            overflow: hidden;
        }

        .project-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .project-header h3 {
            position: relative;
            z-index: 1;
            font-weight: 600;
        }

        .project-header p {
            position: relative;
            z-index: 1;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input-custom {
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid var(--quicky-primary);
        }

        .form-check-input-custom:checked {
            background-color: var(--quicky-primary);
            border-color: var(--quicky-primary);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--quicky-secondary);
            box-shadow: 0 0 0 0.25rem var(--quicky-primary-opacity-15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--quicky-primary) 0%, var(--quicky-secondary) 100%);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--quicky-primary-opacity-15);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--quicky-primary-opacity-15);
            background: linear-gradient(135deg, var(--quicky-primary-hover) 0%, var(--quicky-secondary) 100%);
        }

        .btn-outline-secondary {
            border: 2px solid var(--quicky-text-muted);
            color: var(--quicky-text-secondary);
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: var(--quicky-text-muted);
            border-color: var(--quicky-text-muted);
            color: white;
            transform: translateY(-2px);
        }

        .card-title {
            color: var(--quicky-text-primary);
            font-weight: 600;
        }

        .form-label {
            color: var(--quicky-text-primary);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-text {
            color: var(--quicky-text-muted);
            font-size: 0.875rem;
        }

        .btn-outline-primary {
            border: 2px solid var(--quicky-secondary);
            color: var(--quicky-secondary);
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--quicky-secondary);
            border-color: var(--quicky-secondary);
            color: white;
        }

        .btn-outline-danger {
            border: 2px solid #ff3e1d;
            color: #ff3e1d;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #ff3e1d;
            border-color: #ff3e1d;
            color: white;
        }

        .text-primary {
            color: var(--quicky-primary) !important;
        }

        /* Animation pour les champs ajoutés */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styles pour la section JSON */
        .font-monospace {
            font-family: 'Courier New', Consolas, 'Liberation Mono', Menlo, Courier, monospace;
            font-size: 0.9rem;
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
        }

        .font-monospace:focus {
            background-color: #ffffff;
            border-color: var(--quicky-secondary);
            box-shadow: 0 0 0 0.25rem var(--quicky-primary-opacity-15);
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover,
        .btn-outline-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Amélioration du responsive */
        @media (max-width: 768px) {
            .project-header {
                padding: 1.5rem;
                margin: -2rem -1rem 2rem -1rem;
            }

            .quicky-form-section {
                padding: 1.5rem;
            }

            .form-field-container {
                padding: 1rem;
            }

            .field-controls {
                flex-direction: column;
            }

            .field-controls>* {
                min-width: 100%;
            }

            .font-monospace {
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-xl flex-grow-1 container-p-y">
        <!-- Messages d'alerte -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-check-circle me-2 fs-4"></i>
                    <div>
                        <strong>Succès !</strong> {{ session('success') }}
                        @if (session('files_generated'))
                            <hr class="my-2">
                            <small class="d-block mb-2"><strong>Fichiers générés :</strong></small>
                            @foreach (session('files_generated') as $file)
                                <small class="d-block">{{ $file }}</small>
                            @endforeach
                        @endif
                        @if (session('info'))
                            <hr class="my-2">
                            <small class="text-muted">{{ session('info') }}</small>
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bx bx-error-circle me-2 fs-4 mt-1"></i>
                    <div class="flex-grow-1">
                        <strong>Erreur !</strong>
                        <div class="mt-2" style="white-space: pre-line;">{{ session('error') }}</div>
                        @if (session('debug'))
                            <hr class="my-2">
                            <small class="text-muted">🐛 Debug : {{ session('debug') }}</small>
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle me-2 fs-4"></i>
                    <div>
                        <strong>Erreurs de validation :</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error me-2 fs-4"></i>
                    <div>
                        <strong>Attention !</strong> {{ session('warning') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-info-circle me-2 fs-4"></i>
                    <div>
                        <strong>Info :</strong> {{ session('info') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="project-header">
                            <h3 class="mb-2 text-white">
                                <i class="bx bx-code-alt me-2 text-white"></i>
                                Générateur CRUD Quicky
                            </h3>
                            <p class="mb-0 opacity-75">Créez rapidement vos modules CRUD avec migration automatique</p>
                        </div>

                        <form method="POST" action="{{ route('quicky') }}" onsubmit="return prepareFormSubmission()">
                            @csrf

                            <!-- Configuration du projet -->
                            <div class="quicky-form-section">
                                <h5 class="card-title mb-4">
                                    <i class="bx bx-cog me-2 text-primary"></i>
                                    Configuration du projet
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="projetid" class="form-label">Nom du projet</label>
                                        <input type="text" id="projetid" name="projetid" class="form-control" required
                                            placeholder="Ex: Article, Produit, Commande..."
                                            onchange="capitalizeFirstLetter('projetid')">
                                        <div class="form-text">Le nom affiché dans l'interface</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="projet" class="form-label">ID du projet</label>
                                        <input type="text" id="projet" name="projet" class="form-control" required
                                            placeholder="Ex: article, produit, commande..."
                                            onchange="capitalizeFirstLetter('projet')">
                                        <div class="form-text">Nom technique (utilisé pour les fichiers et routes)</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="colNumber" class="form-label">Nombre de colonnes</label>
                                        <select name="colNumber" id="colNumber" class="form-select"
                                            style="display: block !important;">
                                            <option value="12">1 colonne</option>
                                            <option value="6" selected>2 colonnes</option>
                                            <option value="4">3 colonnes</option>
                                            <option value="3">4 colonnes</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Options</label>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" id="serverSide" name="serverSide" value="1"
                                                checked class="form-check-input form-check-input-custom">
                                            <label for="serverSide" class="form-label mb-0">Server-side DataTable</label>
                                        </div>
                                        <div class="form-text">Pagination côté serveur pour de meilleures performances
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="desc" class="form-label">Description</label>
                                        <textarea name="desc" id="desc" class="form-control" rows="3"
                                            placeholder="Description optionnelle du module..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Import JSON -->
                            <div class="quicky-form-section">
                                <h5 class="card-title mb-4">
                                    <i class="bx bx-code-alt me-2 text-primary"></i>
                                    Import JSON (Optionnel)
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="jsonImport" class="form-label">Structure JSON des champs</label>
                                        <textarea id="jsonImport" class="form-control font-monospace" rows="8"
                                            placeholder='Exemple:
[
  {
    "identifiant": "nom",
    "label": "Nom complet",
    "type": "text",
    "required": true,
    "inGrid": true
  },
  {
    "identifiant": "email",
    "label": "Adresse email",
    "type": "email",
    "required": true,
    "inGrid": true
  },
  {
    "identifiant": "age",
    "label": "Âge",
    "type": "number",
    "required": false,
    "inGrid": true
  }
]'>
@if (session('quicky_json'))
{{ session('quicky_json') }}
@endif
</textarea>
                                        <div class="form-text">
                                            <strong>Types supportés:</strong> text, email, number, password, url, phone,
                                            textarea, ckeditor,
                                            select, radio, checkbox, datepicker, timepicker, colorpicker, file, hidden,
                                            primary_key, secondary_key
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-outline-primary"
                                            onclick="importFromJSON()">
                                            <i class="bx bx-import me-2"></i>
                                            Importer les champs depuis JSON
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary ms-2"
                                            onclick="exportToJSON()">
                                            <i class="bx bx-export me-2"></i>
                                            Exporter en JSON
                                        </button>
                                        <button type="button" class="btn btn-outline-warning ms-2"
                                            onclick="clearAllFields()">
                                            <i class="bx bx-trash me-2"></i>
                                            Vider tous les champs
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Champs du formulaire -->
                            <div class="quicky-form-section">
                                <h5 class="card-title mb-4">
                                    <i class="bx bx-list-ul me-2 text-primary"></i>
                                    Champs du formulaire
                                </h5>

                                <div id="fields-container">
                                    <!-- Les champs seront ajoutés ici dynamiquement -->
                                </div>

                                <button type="button" class="btn btn-add-field text-white" onclick="addField()">
                                    <i class="bx bx-plus me-2 text-white"></i>
                                    Ajouter un champ
                                </button>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bx bx-refresh me-2"></i>
                                    Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-2"></i>
                                    Générer le CRUD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Templates cachés -->
    <div class="d-none">
        <!-- Template pour les champs select/radio/checkbox -->
        <div id="option-template">
            <div class="option-item">
                <input type="text" class="form-control" placeholder="Clé" style="max-width: 100px;">
                <input type="text" class="form-control" placeholder="Valeur">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(this)">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="/assets/vendor/libs/select2/select2.js"></script>

    <script>
        let fieldCounter = 0;

        /**
         * Capitalise la première lettre de chaque mot
         */
        function capitalizeFirstLetter(elementId) {
            const element = document.getElementById(elementId);
            const text = element.value.toLowerCase();
            element.value = text.replace(/^(.)|\s(.)/g, function($1) {
                return $1.toUpperCase();
            });
        }

        /**
         * Ajoute un nouveau champ au formulaire
         */
        function addField() {
            const container = document.getElementById('fields-container');
            const fieldHtml = `
        <div class="form-field-container" data-field-index="${fieldCounter}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Identifiant</label>
                    <input type="text"
                           name="Identifiant[]"
                           class="form-control"
                           placeholder="nom_champ"
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Label</label>
                    <input type="text"
                           name="Label[]"
                           class="form-control"
                           placeholder="Nom du champ"
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <select name="formElement[]"
                            class="form-select"
                            onchange="handleTypeChange(this, ${fieldCounter})"
                            required>
                                        <option value="text">Choisir...</option>
                        <option value="primary_key">Clé primaire</option>
                        <option value="secondary_key">Clé étrangère</option>
                        <option value="text">Texte</option>
                        <option value="select">Liste déroulante</option>
                        <option value="select_basic">Liste simple</option>
                        <option value="select_multiple">Multi-sélection</option>
                        <option value="select_multiple_basic">Multi-sélection simple</option>
                        <option value="textarea">Zone de texte</option>
                        <option value="ckeditor">Éditeur WYSIWYG</option>
                        <option value="radio">Boutons radio</option>
                        <option value="checkbox">Cases à cocher</option>
                        <option value="datepicker">Date</option>
                        <option value="timepicker">Heure</option>
                        <option value="colorpicker">Couleur</option>
                        <option value="file">Fichier</option>
                        <option value="phone">Téléphone</option>
                        <option value="email">Email</option>
                        <option value="number">Nombre</option>
                        <option value="password">Mot de passe</option>
                        <option value="url">URL</option>
                        <option value="hidden">Caché</option>
                    </select>
                </div>


                    <div class="col-md-3">
                    <label class="form-label">Options</label>
                    <div class="d-flex flex-column gap-1">
                        <div class="form-check">
                            <input type="checkbox"
                                   name="visible[]"
                                   value="1"
                                   class="form-check-input"
                                   checked>
                            <label class="form-check-label">Requis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox"
                                   name="inGrid[]"
                                   value="1"
                                   class="form-check-input"
                                   checked>
                            <label class="form-check-label">Dans la liste</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="button"
                            class="btn btn-outline-danger btn-sm"
                            onclick="removeField(this)">
                        <i class="bx bx-trash"></i>
                    </button>
                    <input type="hidden" name="del[]" value="0">
                </div>
            </div>

            <!-- Zone pour les options spécifiques au type -->
            <div id="type-options-${fieldCounter}" class="mt-3" style="display: none;"></div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', fieldHtml);
            fieldCounter++;
        }

        /**
         * Supprime un champ
         */
        function removeField(button) {
            const fieldContainer = button.closest('.form-field-container');
            const hiddenInput = fieldContainer.querySelector('input[name="del[]"]');
            hiddenInput.value = '1';
            fieldContainer.style.display = 'none';
        }

        /**
         * Gère le changement de type de champ
         */
        function handleTypeChange(selectElement, fieldIndex) {
            const optionsContainer = document.getElementById(`type-options-${fieldIndex}`);
            const selectedType = selectElement.value;

            // Réinitialiser le conteneur
            optionsContainer.innerHTML = '';
            optionsContainer.style.display = 'none';

            switch (selectedType) {
                case 'secondary_key':
                    showForeignKeyOptions(optionsContainer, fieldIndex);
                    break;
                case 'select':
                case 'select_basic':
                case 'select_multiple':
                case 'select_multiple_basic':
                    showSelectOptions(optionsContainer, fieldIndex, selectedType);
                    break;
                case 'radio':
                    showRadioOptions(optionsContainer, fieldIndex);
                    break;
                case 'checkbox':
                    showCheckboxOptions(optionsContainer, fieldIndex);
                    break;
            }
        }

        /**
         * Affiche les options pour les clés étrangères
         */
        function showForeignKeyOptions(container, fieldIndex) {
            container.innerHTML = `
        <div class="field-type-options">
            <h6 class="text-primary mb-3">Configuration de la clé étrangère</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Modèle</label>
                    <input type="text"
                           name="skmodel[]"
                           class="form-control"
                           placeholder="Ex: User, Category...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Clé</label>
                    <input type="text"
                           name="skkey[]"
                           class="form-control"
                           placeholder="Ex: id">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Valeur affichée</label>
                    <input type="text"
                           name="skvalue[]"
                           class="form-control"
                           placeholder="Ex: name, title...">
                </div>
            </div>
        </div>
    `;
            container.style.display = 'block';
        }

        /**
         * Affiche les options pour les listes déroulantes
         */
        function showSelectOptions(container, fieldIndex, type) {
            const typePrefix = type.charAt(0).toUpperCase() + type.slice(1);
            container.innerHTML = `
        <div class="field-type-options">
            <h6 class="text-primary mb-3">Options de la liste</h6>
            <div id="select-options-${fieldIndex}" class="options-list mb-3">
                <!-- Les options seront ajoutées ici -->
            </div>
            <button type="button"
                    class="btn btn-sm btn-outline-primary"
                    onclick="addSelectOption(${fieldIndex}, '${type}')">
                <i class="bx bx-plus me-1"></i>
                Ajouter une option
            </button>
        </div>
    `;
            container.style.display = 'block';
        }

        /**
         * Affiche les options pour les boutons radio
         */
        function showRadioOptions(container, fieldIndex) {
            container.innerHTML = `
        <div class="field-type-options">
            <h6 class="text-primary mb-3">Options radio</h6>
            <div id="radio-options-${fieldIndex}" class="options-list mb-3">
                <!-- Les options seront ajoutées ici -->
            </div>
            <button type="button"
                    class="btn btn-sm btn-outline-primary"
                    onclick="addRadioOption(${fieldIndex})">
                <i class="bx bx-plus me-1"></i>
                Ajouter une option
            </button>
        </div>
    `;
            container.style.display = 'block';
        }

        /**
         * Affiche les options pour les cases à cocher
         */
        function showCheckboxOptions(container, fieldIndex) {
            container.innerHTML = `
        <div class="field-type-options">
            <h6 class="text-primary mb-3">Options checkbox</h6>
            <div id="checkbox-options-${fieldIndex}" class="options-list mb-3">
                <!-- Les options seront ajoutées ici -->
            </div>
            <button type="button"
                    class="btn btn-sm btn-outline-primary"
                    onclick="addCheckboxOption(${fieldIndex})">
                <i class="bx bx-plus me-1"></i>
                Ajouter une option
            </button>
        </div>
    `;
            container.style.display = 'block';
        }

        /**
         * Ajoute une option select
         */
        function addSelectOption(fieldIndex, type) {
            const container = document.getElementById(`select-options-${fieldIndex}`);
            const optionHtml = `
        <div class="option-item">
            <input type="text"
                   name="Select_cle[${fieldIndex}][]"
                   class="form-control"
                   placeholder="Clé"
                   style="max-width: 150px;">
            <input type="text"
                   name="Select_valeur[${fieldIndex}][]"
                   class="form-control"
                   placeholder="Valeur">
            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="removeOption(this)">
                <i class="bx bx-trash"></i>
            </button>
            <input type="hidden" name="Select_del[${fieldIndex}][]" value="0">
        </div>
    `;
            container.insertAdjacentHTML('beforeend', optionHtml);
        }

        /**
         * Ajoute une option radio
         */
        function addRadioOption(fieldIndex) {
            const container = document.getElementById(`radio-options-${fieldIndex}`);
            const optionHtml = `
        <div class="option-item">
            <input type="text"
                   name="Radio_cle[${fieldIndex}][]"
                   class="form-control"
                   placeholder="Clé"
                   style="max-width: 150px;">
            <input type="text"
                   name="Radio_valeur[${fieldIndex}][]"
                   class="form-control"
                   placeholder="Valeur">
            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="removeOption(this)">
                <i class="bx bx-trash"></i>
            </button>
            <input type="hidden" name="Radio_del[${fieldIndex}][]" value="0">
        </div>
    `;
            container.insertAdjacentHTML('beforeend', optionHtml);
        }

        /**
         * Ajoute une option checkbox
         */
        function addCheckboxOption(fieldIndex) {
            const container = document.getElementById(`checkbox-options-${fieldIndex}`);
            const optionHtml = `
        <div class="option-item">
            <input type="text"
                   name="Checkbox_cle[${fieldIndex}][]"
                   class="form-control"
                   placeholder="Clé"
                   style="max-width: 150px;">
            <input type="text"
                   name="Checkbox_valeur[${fieldIndex}][]"
                   class="form-control"
                   placeholder="Valeur">
            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="removeOption(this)">
                <i class="bx bx-trash"></i>
            </button>
            <input type="hidden" name="Checkbox_del[${fieldIndex}][]" value="0">
        </div>
    `;
            container.insertAdjacentHTML('beforeend', optionHtml);
        }

        /**
         * Supprime une option
         */
        function removeOption(button) {
            const optionItem = button.closest('.option-item');
            const hiddenInput = optionItem.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                hiddenInput.value = '1';
            }
            optionItem.style.display = 'none';
        }

        /**
         * Importe les champs depuis JSON
         */
        function importFromJSON() {
            const jsonText = document.getElementById('jsonImport').value.trim();

            if (!jsonText) {
                alert('Veuillez saisir une structure JSON valide.');
                return;
            }

            try {
                const fields = JSON.parse(jsonText);

                if (!Array.isArray(fields)) {
                    throw new Error('Le JSON doit être un tableau de champs.');
                }

                // Vider les champs existants
                clearAllFields();

                // Ajouter chaque champ depuis le JSON
                fields.forEach(field => {
                    addFieldFromJSON(field);
                });

                // Message de succès
                showNotification('Champs importés avec succès !', 'success');

            } catch (error) {
                alert('Erreur lors de l\'analyse du JSON: ' + error.message);
                console.error('Erreur JSON:', error);
            }
        }

        /**
         * Exporte les champs actuels en JSON
         */
        function exportToJSON() {
            const fields = [];
            const containers = document.querySelectorAll('.form-field-container:not([style*="display: none"])');

            containers.forEach(container => {
                const identifiant = container.querySelector('input[name="Identifiant[]"]')?.value || '';
                const label = container.querySelector('input[name="Label[]"]')?.value || '';
                const type = container.querySelector('select[name="formElement[]"]')?.value || 'text';
                const required = container.querySelector('input[name="visible[]"]')?.checked || false;
                const inGrid = container.querySelector('input[name="inGrid[]"]')?.checked || false;

                if (identifiant && label) {
                    const field = {
                        identifiant: identifiant,
                        label: label,
                        type: type,
                        required: required,
                        inGrid: inGrid
                    };

                    // Ajouter les options spécifiques selon le type
                    if (['select', 'select_basic', 'radio', 'checkbox'].includes(type)) {
                        field.options = getFieldOptions(container, type);
                    }

                    if (type === 'secondary_key') {
                        field.foreignKey = getFieldForeignKey(container);
                    }

                    fields.push(field);
                }
            });

            const jsonOutput = JSON.stringify(fields, null, 2);
            document.getElementById('jsonImport').value = jsonOutput;

            showNotification('Structure exportée en JSON !', 'info');
        }

        /**
         * Vide tous les champs
         */
        function clearAllFields() {
            const containers = document.querySelectorAll('.form-field-container');
            containers.forEach(container => {
                container.remove();
            });
            fieldCounter = 0;
        }

        /**
         * Ajoute un champ depuis une structure JSON
         */
        function addFieldFromJSON(fieldData) {
            // Ajouter le champ de base
            addField();

            const lastContainer = document.querySelector('.form-field-container:last-child');

            // Remplir les valeurs
            if (fieldData.identifiant) {
                lastContainer.querySelector('input[name="Identifiant[]"]').value = fieldData.identifiant;
            }
            if (fieldData.label) {
                lastContainer.querySelector('input[name="Label[]"]').value = fieldData.label;
            }
            if (fieldData.type) {
                lastContainer.querySelector('select[name="formElement[]"]').value = fieldData.type;
            }
            if (fieldData.hasOwnProperty('required')) {
                lastContainer.querySelector('input[name="visible[]"]').checked = fieldData.required;
            }
            if (fieldData.hasOwnProperty('inGrid')) {
                lastContainer.querySelector('input[name="inGrid[]"]').checked = fieldData.inGrid;
            }

            // Déclencher le changement de type pour afficher les options spécifiques
            const typeSelect = lastContainer.querySelector('select[name="formElement[]"]');
            const fieldIndex = lastContainer.getAttribute('data-field-index');
            handleTypeChange(typeSelect, fieldIndex);

            // Ajouter les options spécifiques selon le type
            setTimeout(() => {
                if (fieldData.options && ['select', 'select_basic', 'radio', 'checkbox'].includes(fieldData.type)) {
                    addFieldOptionsFromJSON(fieldIndex, fieldData.type, fieldData.options);
                }

                if (fieldData.foreignKey && fieldData.type === 'secondary_key') {
                    addFieldForeignKeyFromJSON(fieldIndex, fieldData.foreignKey);
                }
            }, 100);
        }

        /**
         * Ajoute les options d'un champ depuis JSON
         */
        function addFieldOptionsFromJSON(fieldIndex, type, options) {
            if (!options || !Array.isArray(options)) return;

            console.log(`Adding options for field ${fieldIndex}, type ${type}:`, options);

            // D'abord ajouter toutes les options vides
            options.forEach((option, optionIndex) => {
                console.log(`Adding empty option ${optionIndex} for:`, option);

                if (type === 'select' || type === 'select_basic') {
                    addSelectOption(fieldIndex, type);
                } else if (type === 'radio') {
                    addRadioOption(fieldIndex);
                } else if (type === 'checkbox') {
                    addCheckboxOption(fieldIndex);
                }
            });

            // Ensuite remplir toutes les valeurs une fois que tous les éléments sont créés
            setTimeout(() => {
                const container = document.getElementById(`${type}-options-${fieldIndex}`) ||
                    document.getElementById(`select-options-${fieldIndex}`);

                if (container) {
                    const optionItems = container.querySelectorAll('.option-item');
                    console.log(`Found ${optionItems.length} option items, expected ${options.length}`);

                    options.forEach((option, optionIndex) => {
                        if (optionIndex < optionItems.length) {
                            const optionItem = optionItems[optionIndex];
                            const cleInput = optionItem.querySelector('input[placeholder="Clé"]') ||
                                optionItem.querySelector('input[type="text"]:first-child');
                            const valeurInput = optionItem.querySelector('input[placeholder="Valeur"]') ||
                                optionItem.querySelector('input[type="text"]:last-child');

                            // Vérifier les différentes structures possibles
                            const cle = option.cle || option.key || option.id;
                            const valeur = option.valeur || option.value || option.label;

                            console.log(
                                `Setting values for option ${optionIndex}: cle=${cle}, valeur=${valeur}`
                            );

                            if (cleInput && cle) {
                                cleInput.value = cle;
                                console.log(`Set cle input to: ${cle}`);
                            }
                            if (valeurInput && valeur) {
                                valeurInput.value = valeur;
                                console.log(`Set valeur input to: ${valeur}`);
                            }
                        }
                    });
                }
            }, 100); // Timeout plus long pour s'assurer que tous les éléments sont ajoutés
        }

        /**
         * Ajoute les informations de clé étrangère depuis JSON
         */
        function addFieldForeignKeyFromJSON(fieldIndex, foreignKey) {
            const container = document.getElementById(`type-options-${fieldIndex}`);
            if (container && foreignKey) {
                const modelInput = container.querySelector('input[name="skmodel[]"]');
                const keyInput = container.querySelector('input[name="skkey[]"]');
                const valueInput = container.querySelector('input[name="skvalue[]"]');

                if (modelInput && foreignKey.model) modelInput.value = foreignKey.model;
                if (keyInput && foreignKey.key) keyInput.value = foreignKey.key;
                if (valueInput && foreignKey.value) valueInput.value = foreignKey.value;
            }
        }

        /**
         * Récupère les options d'un champ
         */
        function getFieldOptions(container, type) {
            const options = [];
            const optionsContainer = container.querySelector(
                    `#${type}-options-${container.getAttribute('data-field-index')}`) ||
                container.querySelector(`#select-options-${container.getAttribute('data-field-index')}`);

            if (optionsContainer) {
                const optionItems = optionsContainer.querySelectorAll('.option-item:not([style*="display: none"])');
                optionItems.forEach(item => {
                    const cleInput = item.querySelector('input[type="text"]:first-child');
                    const valeurInput = item.querySelector('input[type="text"]:last-child');
                    if (cleInput?.value && valeurInput?.value) {
                        options.push({
                            cle: cleInput.value,
                            valeur: valeurInput.value
                        });
                    }
                });
            }

            return options.length > 0 ? options : undefined;
        }

        /**
         * Récupère les informations de clé étrangère
         */
        function getFieldForeignKey(container) {
            const optionsContainer = container.querySelector(`#type-options-${container.getAttribute('data-field-index')}`);

            if (optionsContainer) {
                const modelInput = optionsContainer.querySelector('input[name="skmodel[]"]');
                const keyInput = optionsContainer.querySelector('input[name="skkey[]"]');
                const valueInput = optionsContainer.querySelector('input[name="skvalue[]"]');

                if (modelInput?.value || keyInput?.value || valueInput?.value) {
                    return {
                        model: modelInput?.value || '',
                        key: keyInput?.value || 'id',
                        value: valueInput?.value || ''
                    };
                }
            }

            return undefined;
        }

        /**
         * Prépare les données du formulaire avant soumission
         */
        function prepareFormSubmission() {
            try {
                // Supprimer physiquement les champs marqués comme supprimés
                const deletedFields = document.querySelectorAll('.form-field-container[style*="display: none"]');
                deletedFields.forEach(field => field.remove());

                // Vérifier qu'il reste au moins un champ visible
                const visibleFields = document.querySelectorAll('.form-field-container:not([style*="display: none"])');
                if (visibleFields.length === 0) {
                    alert('Veuillez ajouter au moins un champ à votre formulaire.');
                    return false;
                }

                // Valider que tous les champs visibles ont un identifiant et un label
                let hasError = false;
                visibleFields.forEach((field, index) => {
                    const identifiant = field.querySelector('input[name="Identifiant[]"]')?.value?.trim();
                    const label = field.querySelector('input[name="Label[]"]')?.value?.trim();
                    const type = field.querySelector('select[name="formElement[]"]')?.value;

                    if (!identifiant) {
                        alert(`Le champ #${index + 1} doit avoir un identifiant.`);
                        hasError = true;
                        return;
                    }
                    if (!label) {
                        alert(`Le champ #${index + 1} doit avoir un label.`);
                        hasError = true;
                        return;
                    }
                    if (!type || type === '') {
                        alert(`Le champ #${index + 1} doit avoir un type.`);
                        hasError = true;
                        return;
                    }

                    // Valider que les champs secondary_key ont bien un modèle défini
                    if (type === 'secondary_key') {
                        const fieldIndex = field.getAttribute('data-field-index');
                        const optionsContainer = document.getElementById(`type-options-${fieldIndex}`);
                        const skmodel = optionsContainer?.querySelector('input[name="skmodel[]"]')?.value?.trim();

                        if (!skmodel || skmodel === '') {
                            alert(
                                `Le champ "${label}" de type "Clé étrangère" doit avoir un modèle défini (Model).`
                                );
                            hasError = true;
                            return;
                        }
                    }
                });

                if (hasError) {
                    return false;
                }

                // Nettoyer les options supprimées
                document.querySelectorAll('.option-item[style*="display: none"]').forEach(option => {
                    option.remove();
                });

                // Ajouter des champs cachés pour les checkboxes non cochées
                const form = document.querySelector('form');
                visibleFields.forEach((field, index) => {
                    const visibleCheckbox = field.querySelector('input[name="visible[]"]');
                    const inGridCheckbox = field.querySelector('input[name="inGrid[]"]');

                    if (!visibleCheckbox.checked) {
                        const hiddenVisible = document.createElement('input');
                        hiddenVisible.type = 'hidden';
                        hiddenVisible.name = 'visible_unchecked[]';
                        hiddenVisible.value = index;
                        form.appendChild(hiddenVisible);
                    }

                    if (!inGridCheckbox.checked) {
                        const hiddenInGrid = document.createElement('input');
                        hiddenInGrid.type = 'hidden';
                        hiddenInGrid.name = 'inGrid_unchecked[]';
                        hiddenInGrid.value = index;
                        form.appendChild(hiddenInGrid);
                    }
                });

                // Debug : afficher ce qui va être soumis
                console.log('=== DEBUG SOUMISSION FORMULAIRE ===');
                const formData = new FormData(document.querySelector('form'));
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }
                console.log('=== FIN DEBUG SOUMISSION ===');

                return true;
            } catch (error) {
                console.error('Erreur lors de la préparation du formulaire:', error);
                alert('Une erreur est survenue lors de la préparation du formulaire.');
                return false;
            }
        }

        /**
         * Affiche une notification
         */
        function showNotification(message, type = 'info') {
            // Créer la notification
            const notification = document.createElement('div');
            notification.className =
                `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show`;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';

            notification.innerHTML = `
                <strong>${type === 'success' ? 'Succès!' : type === 'error' ? 'Erreur!' : 'Info!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(notification);

            // Supprimer automatiquement après 3 secondes
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser Select2 pour les sélecteurs existants (sauf colNumber)
            $('.form-select:not(#colNumber)').select2({
                theme: 'bootstrap-5',
                placeholder: 'Sélectionner...',
                allowClear: true
            });

            // Ajouter un champ par défaut
            addField();
        });
    </script>
@endsection
