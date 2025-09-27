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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible mb-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
            <h5 class="card-header">Modifier le client</h5>
            <form class="card-body" method="POST" action="{{ route('client.update', ['client' => $record->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    @can('client.is_priority.update')
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_priority" name="is_priority"
                                        {{ old('is_priority', $record->is_priority) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_priority">Client prioritaire</label>
                                </div>
                                @error('is_priority')
                                    <span class="helper-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endcan
                    @can('client.name.update')
                        <div class="col-md-6">
                            <label class="form-label" for="name">Nom</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nom du client"
                                value="{{ old('name', $record->name) }}" required />
                            @error('name')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('client.link.update')
                        <div class="col-md-6">
                            <label class="form-label" for="link">Lien</label>
                            <input type="text" name="link" id="link" class="form-control"
                                placeholder="Lien personnalisé" value="{{ old('link', $record->link) }}" />
                            @error('link')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    @can('client.icon_image.update')
                        <div class="col-md-6">
                            <label class="form-label" for="icon_image">Icône</label>
                            <input type="file" name="icon_image" id="icon_image" class="form-control" accept="image/*" />
                            @error('icon_image')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                            @if ($record->icon_image)
                                <div class="image-preview-container">
                                    <img src="{{ asset($record->icon_image) }}" class="preview-image" id="icon_image_preview"
                                        data-has-image="{{ $record->icon_image ? 'true' : 'false' }}"
                                        onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg=='; this.setAttribute('data-has-image', 'false'); document.getElementById('remove_icon_image').style.display = 'none';" />
                                    <button type="button" class="btn btn-sm btn-icon btn-danger remove-image"
                                        id="remove_icon_image" onclick="removeImage('icon_image')"
                                        style="display: {{ $record->icon_image ? 'block' : 'none' }}">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endcan

                    @can('client.image.update')
                        <div class="col-md-6">
                            <label class="form-label" for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                            @error('image')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                            @if ($record->image)
                                <div class="image-preview-container">
                                    <img src="{{ asset($record->image) }}" class="preview-image" id="image_preview"
                                        data-has-image="{{ $record->image ? 'true' : 'false' }}"
                                        onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg=='; this.setAttribute('data-has-image', 'false'); document.getElementById('remove_image').style.display = 'none';" />
                                    <button type="button" class="btn btn-sm btn-icon btn-danger remove-image"
                                        id="remove_image" onclick="removeImage('image')"
                                        style="display: {{ $record->image ? 'block' : 'none' }}">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                            @endif
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
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    if (preview) {
                        preview.src = e.target.result;
                        preview.setAttribute('data-has-image', 'true');
                        document.getElementById('remove_' + input.id).style.display = 'block';
                    } else {
                        const newPreview = document.createElement('img');
                        newPreview.id = previewId;
                        newPreview.src = e.target.result;
                        newPreview.classList.add('preview-image');
                        newPreview.setAttribute('data-has-image', 'true');
                        input.parentNode.appendChild(newPreview);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Suppression des images
        function removeImage(fieldName) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
                const preview = document.getElementById(`${fieldName}_preview`);
                if (preview.getAttribute('data-has-image') === 'true') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `remove_${fieldName}`;
                    input.value = '1';
                    document.querySelector('form').appendChild(input);
                    preview.src =
                        'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg==';
                    preview.setAttribute('data-has-image', 'false');
                    document.getElementById(`remove_${fieldName}`).style.display = 'none';
                    document.getElementById(fieldName).value = '';
                }
            }
        }

        // Écouteurs d'événements pour la prévisualisation
        document.getElementById('icon_image').addEventListener('change', function() {
            previewImage(this, 'icon_image_preview');
        });

        document.getElementById('image').addEventListener('change', function() {
            previewImage(this, 'image_preview');
        });
    </script>
@stop
