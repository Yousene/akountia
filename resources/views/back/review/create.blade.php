@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
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
    </style>
@stop
@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Gestion des reviews</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('review.index') }}">Liste des reviews</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Multi Column with Form Separator -->
        <div class="card mb-4">
            <h5 class="card-header"></h5>
            <form class="card-body" method="POST" action="{{ route('review.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    @can('review.validation.create')
                        <div class="col-md-12">
                            <label class="form-label" for="validation">Validation</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="validation" name="validation" value="1"
                                    {{ old('validation') ? 'checked' : '' }}>
                                <label class="form-check-label" for="validation">Review validée</label>
                            </div>
                            @error('validation')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.picture.create')
                        <div class="col-md-6">
                            <label class="form-label" for="picture">Photo de profil</label>
                            <input type="file" name="picture" id="picture" class="form-control" accept="image/*" />
                            <small class="text-muted">Format recommandé : JPG, PNG, SVG, WEBP (max 2MB)</small>
                            @error('picture')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.rating.create')
                        <div class="col-md-6">
                            <label class="form-label" for="rating">Notation</label>
                            <div class="rating-stars mb-2">
                                @php
                                    $currentRating = old('rating', 5);
                                @endphp
                            </div>
                            <div class="mt-2">
                                <div class="input-group" style="max-width: 150px;">
                                    <input type="number" class="form-control" id="rating-input" name="rating"
                                        value="{{ $currentRating }}" step="0.5" min="0.5" max="5"
                                        onchange="updateStars(this.value)">
                                    <span class="input-group-text"><i class="bx bxs-star text-warning"></i></span>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Cliquez sur les étoiles ou utilisez le champ numérique (de
                                0.5 à 5 étoiles)</small>
                            @error('rating')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.name.create')
                        <div class="col-md-3">
                            <label class="form-label" for="name">Nom et prénom</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nom et prénom"
                                value="{{ old('name') }}" />
                            @error('name')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.genre.create')
                        <div class="col-md-1">
                            <label class="form-label" for="genre">Genre</label>
                            <select name="genre" id="genre" class="form-select">
                                <option value="">Sélectionner un genre</option>
                                <option value="Homme" {{ old('genre') == 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('genre') == 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('genre')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.company.create')
                        <div class="col-md-2">
                            <label class="form-label" for="company">Entreprise</label>
                            <input type="text" name="company" id="company" class="form-control" placeholder="Entreprise"
                                value="{{ old('company') }}" />
                            @error('company')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.company_url.create')
                        <div class="col-md-2">
                            <label class="form-label" for="company_url">URL de l'entreprise</label>
                            <input type="url" name="company_url" id="company_url" class="form-control"
                                placeholder="https://example.com" value="{{ old('company_url') }}" />
                            @error('company_url')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.position.create')
                        <div class="col-md-4">
                            <label class="form-label" for="position">Poste occupé</label>
                            <input type="text" name="position" id="position" class="form-control"
                                placeholder="Poste occupé" value="{{ old('position') }}" />
                            @error('position')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.course_id.create')
                        <div class="col-md-6">
                            <label class="form-label" for="course_id">Formation</label>
                            <select name="course_id" id="course_id" class="select2 form-control" data-allow-clear="true">
                                @foreach ($coursesRecords as $row)
                                    <option class="option" {{ $row->id == old('course_id') ? 'selected' : '' }}
                                        value="{{ $row->id }}"> {{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('review.comment.create')
                        <div class="col-md-6">
                            <label class="form-label" for="comment">Commentaire</label>
                            <input type="text" name="comment" id="comment" class="form-control"
                                placeholder="Commentaire" value="{{ old('comment') }}" />
                            @error('comment')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    <!--updates_fields-->
                </div>
                <hr class="my-4 mx-n4" />
                <div class="pt-4 float-end">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
                </div>
                <div class="pt-4 float-start">
                    <button type="reset" class="btn btn-label-secondary">Vider</button>
                    <a href="{{ route('review.index') }}" class="btn btn-label-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
@stop
@section('js')
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/js/forms-selects.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>

    <script type="text/javascript">
        // Select all date inputs
        const flatpickrDates = document.querySelectorAll('.quicky-date');

        // Apply flatpickr to each date input
        flatpickrDates.forEach(function(flatpickrDate) {
            flatpickrDate.flatpickr({
                monthSelectorType: 'static'
            });
        });

        // Select all time inputs
        const flatpickrTimes = document.querySelectorAll('.quicky-time');

        // Apply flatpickr to each time input
        flatpickrTimes.forEach(function(flatpickrTime) {
            flatpickrTime.flatpickr({
                enableTime: true,
                noCalendar: true,
                time_24hr: true
            });
        });

        // Gestion de l'aperçu de l'image
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Gestion du changement de genre pour l'image par défaut
        document.getElementById('genre').addEventListener('change', function() {
            const picturePreview = document.getElementById('picture_preview');
            const currentPicture = picturePreview.src;

            if (currentPicture.includes('default-male.png') || currentPicture.includes('default-female.png')) {
                picturePreview.src = this.value === 'Femme' ?
                    '/storage/reviews/default-female.png' :
                    '/storage/reviews/default-male.png';
            }
        });

        function updateStars(value) {
            // Met à jour la sélection des étoiles quand le champ numérique change
            const radioBtn = document.querySelector(`input[name="rating"][value="${value}"]`);
            if (radioBtn) {
                radioBtn.checked = true;
            }
        }

        // Met à jour le champ numérique quand les étoiles sont cliquées
        document.querySelectorAll('.rating-stars input').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('rating-input').value = this.value;
            });
        });

        // Validation du champ numérique
        document.getElementById('rating-input').addEventListener('input', function() {
            let value = parseFloat(this.value);
            if (value < 0.5) this.value = 0.5;
            if (value > 5) this.value = 5;
            // Arrondir à 0.5 près
            this.value = Math.round(value * 2) / 2;
            updateStars(this.value);
        });
    </script>
@stop
