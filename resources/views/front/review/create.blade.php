@extends('layouts.front')

@section('title', 'Partagez votre avis sur votre formation - Afrique Academy')

@section('meta_description',
    'Donnez votre avis sur votre formation chez Afrique Academy. Partagez votre expérience et
    aidez les futurs apprenants à faire leur choix.')

@section('og_image', asset('assets/img/pages/og_default_image_afriqueacademy.webp'))

@section('css')
    <style>
        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
        }

        .rating-stars input {
            display: none;
        }

        .star-label {
            cursor: pointer;
            font-size: 1.5rem;
            padding: 0 0.2rem;
            color: #dee2e6;
        }

        .rating-stars input:checked~label {
            color: #ffc107;
        }

        .rating-stars label:hover,
        .rating-stars label:hover~label {
            color: #ffdb4d;
        }

        .bi-star-fill,
        .bi-star-half {
            color: #ffc107;
        }

        .bi-star {
            color: #dee2e6;
        }

        /* Styles personnalisés pour Select2 */
        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            padding: 0.375rem 0.75rem;
            background-color: var(--bg-primary);
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            color: var(--text-secondary);
            line-height: 1.5;
            padding-left: 0;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 36px;
            width: 36px;
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            border-color: var(--primary);
            box-shadow: 0 0.25rem 1rem rgba(161, 172, 184, 0.45);
            border-radius: 0.375rem;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary);
            color: white;
        }

        .select2-container--bootstrap-5 .select2-search__field {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
        }

        .select2-container--bootstrap-5 .select2-search__field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 85, 110, 0.25);
            outline: 0;
        }

        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 85, 110, 0.25);
        }

        .select2-container--bootstrap-5 .select2-results__option {
            padding: 0.5rem 0.75rem;
        }

        .select2-container--bootstrap-5 .select2-results__option[aria-selected=true] {
            background-color: var(--primary-light);
        }

        /* Styles pour l'input number - version améliorée */
        input[type="number"].form-control {
            -moz-appearance: textfield;
            padding-right: 1.5rem !important;
        }

        input[type="number"].form-control::-webkit-outer-spin-button,
        input[type="number"].form-control::-webkit-inner-spin-button {
            -webkit-appearance: inner-spin-button !important;
            appearance: inner-spin-button !important;
            opacity: 1 !important;
            margin: 0;
            height: 100%;
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 1.5em;
            border-left: 1px solid #ced4da;
            background-color: #f8f9fa;
        }

        /* Styles spécifiques pour mobile */
        @media (max-width: 767px) {

            input[type="number"].form-control::-webkit-outer-spin-button,
            input[type="number"].form-control::-webkit-inner-spin-button {
                transform: scale(1.5);
                width: 2em;
                background-color: #e9ecef;
            }

            input[type="number"].form-control {
                padding-right: 2em !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0">Partagez votre expérience</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('public.review.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Prénom et nom *</label>
                                    <input type="text" name="name" id="name" class="form-control" required
                                        placeholder="Votre nom complet" value="{{ old('name') }}" />
                                    <small class="text-muted">Vous pouvez utiliser votre prénom suivi de l'initiale de votre
                                        nom (ex: Jean D.)</small>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="genre">Genre *</label>
                                    <select name="genre" id="genre" class="form-select" required>
                                        <option value="">Sélectionner un genre</option>
                                        <option value="Homme" {{ old('genre') == 'Homme' ? 'selected' : '' }}>Homme
                                        </option>
                                        <option value="Femme" {{ old('genre') == 'Femme' ? 'selected' : '' }}>Femme
                                        </option>
                                    </select>
                                    @error('genre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="company">Entreprise *</label>
                                    <input type="text" name="company" id="company" class="form-control" required
                                        placeholder="Votre entreprise" value="{{ old('company') }}" />
                                    @error('company')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="position">Poste occupé *</label>
                                    <input type="text" name="position" id="position" class="form-control" required
                                        placeholder="Votre poste" value="{{ old('position') }}" />
                                    @error('position')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="course_id">Formation suivie *</label>
                                    <select name="course_id" id="course_id" class="form-select select2" required>
                                        <option value="">Sélectionner une formation</option>
                                        @foreach ($coursesRecords as $course)
                                            <option value="{{ $course->id }}"
                                                {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Votre note * (sur 5)</label>
                                    <div class="rating-stars mb-2">
                                        <div class="mt-2">
                                            <div class="input-group" style="max-width: 200px;">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="decrementRating()">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control text-center" id="rating-input"
                                                    name="rating" value="{{ old('rating', 5) }}" step="0.5"
                                                    min="0.5" max="5" required
                                                    onchange="updateStars(this.value)">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="incrementRating()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <span class="input-group-text">
                                                    <i class="fas fa-star text-warning"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Notez votre expérience de formation sur 5 étoiles</small>
                                    @error('rating')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="comment">Votre commentaire *</label>
                                    <textarea name="comment" id="comment" class="form-control" rows="4" required
                                        placeholder="Partagez votre expérience...">{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="picture">Photo de profil (facultatif)</label>
                                    <input type="file" name="picture" id="picture" class="form-control"
                                        accept="image/*" />
                                    <small class="text-muted">Format recommandé : JPG, PNG, SVG, WEBP (max 2MB). L'ajout
                                        d'une photo n'est pas obligatoire mais permet d'authentifier votre avis.</small>
                                    @error('picture')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="consent" id="consent"
                                        required>
                                    <label class="form-check-label" for="consent">
                                        J'accepte que mon avis et les informations fournies soient publiés sur le site web
                                        d'Afrique Academy.
                                        Ces informations pourront être affichées publiquement pour aider d'autres
                                        participants
                                        dans leur choix de formation. *
                                    </label>
                                    @error('consent')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary" id="submitButton" disabled>Envoyer mon
                                    avis</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Fonction pour vérifier si Select2 est chargé
        function checkSelect2() {
            return typeof $.fn.select2 !== 'undefined';
        }

        // Fonction pour charger Select2 si nécessaire
        function loadSelect2() {
            if (!checkSelect2()) {
                var script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
                script.onload = initializeSelect2;
                document.head.appendChild(script);
            } else {
                initializeSelect2();
            }
        }

        // Fonction d'initialisation de Select2
        function initializeSelect2() {
            try {
                $('.select2').select2({
                    placeholder: "Rechercher une formation...",
                    allowClear: true,
                    width: '100%',
                    theme: 'bootstrap-5',
                    language: {
                        noResults: function() {
                            return "Aucun résultat trouvé";
                        },
                        searching: function() {
                            return "Recherche en cours...";
                        },
                        removeAllItems: function() {
                            return "Effacer la sélection";
                        }
                    },
                    templateResult: formatOption,
                    templateSelection: formatOption
                });
                console.log('Select2 initialisé avec succès');
            } catch (e) {
                console.error('Erreur lors de l\'initialisation de Select2:', e);
            }
        }

        // Fonction pour formater les options
        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }

            return $('<span>', {
                class: 'select2-option',
                html: '<span class="option-text">' + option.text + '</span>'
            });
        }

        // Attendre que jQuery soit chargé
        function waitForJQuery() {
            if (typeof jQuery !== 'undefined') {
                loadSelect2();
            } else {
                setTimeout(waitForJQuery, 100);
            }
        }

        // Démarrer le processus
        waitForJQuery();

        // Reste du code JavaScript existant...
        function updateStars(value) {
            document.getElementById('rating-input').value = value;
        }

        function incrementRating() {
            let input = document.getElementById('rating-input');
            let value = parseFloat(input.value);
            if (value < 5) {
                input.value = Math.min(5, Math.round((value + 0.5) * 2) / 2);
                updateStars(input.value);
            }
        }

        function decrementRating() {
            let input = document.getElementById('rating-input');
            let value = parseFloat(input.value);
            if (value > 0.5) {
                input.value = Math.max(0.5, Math.round((value - 0.5) * 2) / 2);
                updateStars(input.value);
            }
        }

        document.getElementById('consent').addEventListener('change', function() {
            document.getElementById('submitButton').disabled = !this.checked;
        });
    </script>
@endsection
