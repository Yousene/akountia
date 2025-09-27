@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <style>
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }

        .image-preview-container {
            position: relative;
            display: inline-block;
        }

        .remove-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">
                    <i class="bx bx-group text-primary me-2"></i>
                    Gestion des clients
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
                            <a href="{{ route('client.index') }}">Liste des clients</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Créer un nouveau client</h5>
            <form class="card-body" method="POST" action="{{ route('client.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    @can('client.name.create')
                        <div class="col-md-6">
                            <label class="form-label" for="name">Nom</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nom du client"
                                value="{{ old('name') }}" required />
                            @error('name')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('client.link.create')
                        <div class="col-md-6">
                            <label class="form-label" for="link">Lien</label>
                            <input type="text" name="link" id="link" class="form-control"
                                placeholder="Lien personnalisé" value="{{ old('link') }}" />
                            @error('link')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('client.icon_image.create')
                        <div class="col-md-6">
                            <label class="form-label" for="icon_image">Icône</label>
                            <input type="file" name="icon_image" id="icon_image" class="form-control" accept="image/*" />
                            @error('icon_image')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                            <div class="image-preview-container" id="icon_image_container"></div>
                        </div>
                    @endcan

                    @can('client.image.create')
                        <div class="col-md-6">
                            <label class="form-label" for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                            @error('image')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                            <div class="image-preview-container" id="image_container"></div>
                        </div>
                    @endcan
                </div>

                <hr class="my-4 mx-n4" />

                <div class="pt-4 float-end">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
                </div>
                <div class="pt-4 float-start">
                    <button type="reset" class="btn btn-label-secondary">Vider</button>
                    <a href="{{ route('client.index') }}" class="btn btn-label-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/js/forms-selects.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>

    <script>
        // Prévisualisation des images
        function previewImage(input, containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = ''; // Vider le conteneur existant

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.createElement('div');
                    previewContainer.className = 'image-preview-container';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-image';

                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'btn btn-sm btn-icon btn-danger remove-image';
                    removeButton.innerHTML = '<i class="bx bx-x"></i>';
                    removeButton.onclick = function() {
                        input.value = '';
                        container.innerHTML = '';
                    };

                    previewContainer.appendChild(img);
                    previewContainer.appendChild(removeButton);
                    container.appendChild(previewContainer);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Écouteurs d'événements pour la prévisualisation
        document.getElementById('icon_image').addEventListener('change', function() {
            previewImage(this, 'icon_image_container');
        });

        document.getElementById('image').addEventListener('change', function() {
            previewImage(this, 'image_container');
        });

        // Réinitialisation des prévisualisations lors du reset du formulaire
        document.querySelector('form').addEventListener('reset', function() {
            document.getElementById('icon_image_container').innerHTML = '';
            document.getElementById('image_container').innerHTML = '';
        });
    </script>
@stop
