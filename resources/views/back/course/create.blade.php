@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/tinymce/skins/ui/oxide/skin.min.css" />
    <style>
        .upload-container {
            max-width: 300px;
        }

        .form-group {
            position: relative;
        }

        .helper-text {
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        .fw-bold {
            color: #566a7f;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible mb-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">
                    <i class="bx bx-book-content text-primary me-2"></i>
                    Gestion des formations
                </h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">
                                <i class="bx bx-home-alt text-primary me-1"></i>
                                Accueil
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('course.index') }}">
                                <i class="bx bx-list-ul text-primary me-1"></i>
                                Liste des formations
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Multi Column with Form Separator -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bx bx-plus me-2"></i>
                Nouvelle formation
            </div>
            <form class="card-body" method="POST" action="{{ route('course.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Informations générales -->
                <div class="row g-3">
                    <!-- Images -->
                    <div class="row g-3 mt-2">
                        <h6 class="fw-bold py-3 mb-2">
                            <i class="bx bx-images text-primary me-2"></i>
                            Images
                        </h6>

                        @can('course.icon_image.create')
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label d-block" for="icon_image">Image d'accueil</label>
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="upload-container">
                                            <input type="file" name="icon_image" id="icon_image" class="form-control"
                                                accept="image/*" onchange="previewImage(this, 'icon_image_preview')" />
                                        </div>
                                        <img id="icon_image_preview"
                                            src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg=="
                                            class="rounded" style="width: 60px; height: 60px;">
                                    </div>
                                    @error('icon_image')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.sidebar_image.create')
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label d-block" for="sidebar_image">Image de la page</label>
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="upload-container">
                                            <input type="file" name="sidebar_image" id="sidebar_image" class="form-control"
                                                accept="image/*" onchange="previewImage(this, 'sidebar_image_preview')" />
                                        </div>
                                        <img id="sidebar_image_preview"
                                            src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg=="
                                            class="rounded" style="width: 60px; height: 60px;">
                                    </div>
                                    @error('sidebar_image')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.description_image.create')
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label d-block" for="description_image">Image dans détails</label>
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="upload-container">
                                            <input type="file" name="description_image" id="description_image"
                                                class="form-control" accept="image/*"
                                                onchange="previewImage(this, 'description_image_preview')" />
                                        </div>
                                        <img id="description_image_preview"
                                            src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg=="
                                            class="rounded" style="width: 60px; height: 60px;">
                                    </div>
                                    @error('description_image')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                    </div>

                    <!-- Informations générales -->
                    <div class="row g-3">
                        <h6 class="fw-bold py-3 mb-2">
                            <i class="bx bx-info-circle text-primary me-2"></i>
                            Informations générales
                        </h6>
                        @can('course.is_certified.create')
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_certified"
                                            name="is_certified" {{ old('is_certified') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_certified">Formation certifiante</label>
                                    </div>
                                    @error('is_certified')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.name.create')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Nom de la formation <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" />
                                    <small class="text-muted">Donnez un titre clair et descriptif à votre formation (maximum
                                        250 caractères)</small>
                                    @error('name')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.category.create')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="category_id">Catégorie <span
                                            class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="select2 form-control"
                                        data-allow-clear="true">
                                        <option value="">Sélectionner une catégorie</option>
                                        @foreach ($categoryRecords as $row)
                                            <option value="{{ $row->id }}"
                                                {{ old('category_id') == $row->id ? 'selected' : '' }}>
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Choisissez la catégorie qui correspond le mieux au contenu de
                                        votre formation</small>
                                    @error('category_id')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan



                        @can('course.duration.create')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="duration">Durée</label>
                                    <input type="number" step="0.01" min="0" name="duration" id="duration"
                                        class="form-control" value="{{ old('duration') }}" />
                                    <small class="text-muted">Indiquez la durée numérique de la formation (ex: 2.5)</small>
                                    @error('duration')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.duration_unit.create')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="duration_unit">Unité de durée</label>
                                    <select name="duration_unit" id="duration_unit" class="form-select">
                                        <option value="">Sélectionner une unité</option>
                                        @foreach (['heures', 'jours', 'semaines', 'mois'] as $unit)
                                            <option value="{{ $unit }}"
                                                {{ old('duration_unit') == $unit ? 'selected' : '' }}>
                                                {{ ucfirst($unit) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Sélectionnez l'unité de temps correspondant à la durée de votre
                                        formation</small>
                                    @error('duration_unit')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                    </div>

                    <div class="row g-3 mt-2">
                        <h6 class="fw-bold py-3 mb-2">
                            <i class="bx bx-detail text-primary me-2"></i>
                            Description et détails
                        </h6>
                        @can('course.short_description.create')
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="short_description">Description courte</label>
                                    <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ old('short_description') }}</textarea>
                                    <small class="text-muted">Résumé bref de la formation (maximum 500 caractères)</small>
                                    @error('short_description')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                        @can('course.prerequisites.create')
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="prerequisites">Prérequis</label>
                                    <textarea type="text" name="prerequisites" id="prerequisites" class="form-control" rows="3">{{ old('prerequisites') }}</textarea>
                                    <small class="text-muted">Listez les prérequis nécessaires pour suivre cette
                                        formation - Utilisez une ligne vide (Saut de ligne) pour séparer les
                                        différentes sections</small>
                                    @error('prerequisites')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                        @can('course.target_audience.create')
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="target_audience">Public cible</label>
                                    <textarea type="text" name="target_audience" id="target_audience" class="form-control" rows="3">{{ old('target_audience') }}</textarea>
                                    <small class="text-muted">Précisez à qui s'adresse cette formation - Utilisez une
                                        ligne vide (Saut de ligne) pour séparer les différentes sections</small>
                                    @error('target_audience')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.description.create')
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">Description complète</label>
                                    <textarea class="form-control" id="description" name="description" rows="6">{{ old('description') }}</textarea>
                                    <small class="text-muted">Description détaillée du contenu et du déroulement de la
                                        formation</small>
                                    @error('description')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.objectives.create')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="objectives">Objectifs</label>
                                    <textarea class="form-control" id="objectives" name="objectives" rows="4">{{ old('objectives') }}</textarea>
                                    <small class="text-muted">Listez les compétences et connaissances acquises à l'issue de la
                                        formation - Utilisez une ligne vide (Saut de ligne) pour séparer les
                                        différentes sections</small>
                                    @error('objectives')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.teaching_methods.create')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="teaching_methods">Méthodes pédagogiques</label>
                                    <textarea class="form-control" id="teaching_methods" name="teaching_methods" rows="4">{{ old('teaching_methods') }}</textarea>
                                    <small class="text-muted">Décrivez les approches pédagogiques utilisées (ex: cours
                                        théoriques, exercices pratiques, études de cas) - Utilisez une ligne vide
                                        (Saut de ligne) pour séparer les différentes sections</small>
                                    @error('teaching_methods')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('course.program.create')
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="program">
                                        <i class="bx bx-list-ul text-primary me-2"></i>
                                        Programme de la formation</label>
                                    <div id="modules-container">
                                        <div class="modules-list">
                                            <!-- Les modules seront ajoutés ici dynamiquement -->
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addModule()">
                                            <i class="bx bx-plus me-1"></i>
                                            Ajouter un module
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endcan

                        @can('course.faqs.create')
                            <div class="row g-3 mt-2">
                                <h6 class="fw-bold py-3 mb-2">
                                    <i class="bx bx-question-mark text-primary me-2"></i>
                                    FAQ
                                </h6>

                                <div class="col-12">
                                    <div id="faqs-container">
                                        <div class="faqs-list">
                                            @if (old('faqs'))
                                                @foreach (old('faqs') as $index => $faq)
                                                    <div class="faq-item card p-3 mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="faq-number">{{ $index + 1 }}</span>
                                                            <button type="button" class="btn btn-sm btn-danger remove-faq">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Question</label>
                                                            <input type="text" name="faqs[{{ $index }}][question]"
                                                                class="form-control" value="{{ $faq['question'] ?? '' }}">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Réponse</label>
                                                            <textarea name="faqs[{{ $index }}][answer]" class="form-control" rows="3">{{ $faq['answer'] ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addFaq()">
                                            <i class="bx bx-plus me-1"></i>
                                            Ajouter une question
                                        </button>
                                        <small class="d-block text-muted mt-2">Ajoutez les questions fréquemment posées
                                            concernant cette formation</small>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>

                    <!-- Images -->

                    <hr class="my-4 mx-n4" />

                    <div class="pt-4 d-flex justify-content-between">
                        <div>
                            <button type="reset" class="btn btn-label-secondary me-2">
                                <i class="bx bx-reset me-1"></i>
                                Réinitialiser
                            </button>
                            <a href="{{ route('course.index') }}" class="btn btn-label-secondary">
                                <i class="bx bx-arrow-back me-1"></i>
                                Retour
                            </a>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('js')
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/js/forms-selects.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="/assets/vendor/libs/tinymce/tinymce.min.js"></script>

    <script type="text/javascript">
        // Configuration TinyMCE
        tinymce.init({
            selector: '.tinymce',
            height: 350,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'paste'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
            language: 'fr_FR',
            paste_as_text: true
        });

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script type="text/javascript">
        // Gestion des modules
        let moduleCount = 0;
        const container = document.querySelector('.modules-list');

        // Fonction pour restaurer les anciens modules
        function restoreOldModules() {
            const oldModules = @json(session('oldModules', []));
            if (oldModules.length > 0) {
                oldModules.forEach(moduleData => {
                    addModule(moduleData);
                });
            }
        }

        function addModule(oldData = null) {
            const moduleHtml = `
                <div class="module-item card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Module <span class="module-number">${moduleCount + 1}</span></h6>
                        <button type="button" class="btn btn-danger btn-sm remove-module">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Titre du module</label>
                        <input type="text" name="modules[${moduleCount}][title]" class="form-control" required
                            value="${oldData ? oldData.title : ''}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contenu du module</label>
                        <textarea name="modules[${moduleCount}][content]" class="form-control" rows="3" required>${oldData ? oldData.content : ''}</textarea>
                        <small class="text-muted">Décrivez le contenu de ce module - Utilisez une ligne vide (Saut de ligne) pour séparer les différentes sections</small>
                    </div>
                </div>
            `;

            const moduleElement = document.createElement('div');
            moduleElement.innerHTML = moduleHtml;
            container.appendChild(moduleElement);

            moduleElement.querySelector('.remove-module').addEventListener('click', function() {
                moduleElement.remove();
                updateModuleNumbers();
            });

            moduleCount++;
            updateModuleNumbers();
        }

        function updateModuleNumbers() {
            const modules = container.querySelectorAll('.module-item');
            modules.forEach((module, index) => {
                module.querySelector('.module-number').textContent = index + 1;

                const inputs = module.querySelectorAll('[name^="modules["]');
                inputs.forEach(input => {
                    input.name = input.name.replace(/modules\[\d+\]/, `modules[${index}]`);
                });
            });
            moduleCount = modules.length;
        }

        // Appeler la restauration des modules au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            restoreOldModules();
            restoreOldFaqs();
        });
    </script>

    @if (session('oldModules'))
        <script>
            // Cette variable sera utilisée par le JavaScript pour restaurer les modules
            window.oldModules = @json(session('oldModules'));
        </script>
    @endif

    <script type="text/javascript">
        // Gestion des FAQs
        let faqCount = 0;
        const faqContainer = document.querySelector('.faqs-list');

        function addFaq() {
            const faqHtml = `
                <div class="faq-item card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Question <span class="faq-number">${faqCount + 1}</span></h6>
                        <button type="button" class="btn btn-danger btn-sm remove-faq">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Question</label>
                        <input type="text" name="faqs[${faqCount}][question]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Réponse</label>
                        <textarea name="faqs[${faqCount}][answer]" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            `;

            const faqElement = document.createElement('div');
            faqElement.innerHTML = faqHtml;
            faqContainer.appendChild(faqElement);

            faqElement.querySelector('.remove-faq').addEventListener('click', function() {
                faqElement.remove();
                updateFaqNumbers();
            });

            faqCount++;
            updateFaqNumbers();
        }

        function updateFaqNumbers() {
            const faqs = faqContainer.querySelectorAll('.faq-item');
            faqs.forEach((faq, index) => {
                faq.querySelector('.faq-number').textContent = index + 1;
                const inputs = faq.querySelectorAll('[name^="faqs["]');
                inputs.forEach(input => {
                    input.name = input.name.replace(/faqs\[\d+\]/, `faqs[${index}]`);
                });
            });
        }
    </script>

    <script type="text/javascript">
        function restoreOldFaqs() {
            @if (old('faqs'))
                const faqs = @json(old('faqs'));
                faqs.forEach((faq, index) => {
                    addFaq(faq.question, faq.answer);
                });
            @endif
        }
    </script>
@stop
