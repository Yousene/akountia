@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
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
                    <i class="bx bx-category text-primary me-2"></i>
                    Gestion des catégories
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
                            <a href="{{ route('category.index') }}">
                                <i class="bx bx-list-ul text-primary me-1"></i>
                                Liste des catégories
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bx bx-edit me-2"></i>
                Modifier la catégorie
            </div>
            <form class="card-body" method="POST" action="{{ route('category.update', ['category' => $record->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('Put')

                <div class="row g-3">
                    <div class="row g-3 mt-2">
                        <h6 class="fw-bold py-3 mb-2">
                            <i class="bx bx-images text-primary me-2"></i>
                            Images
                        </h6>

                        @can('category.background_image.update')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label d-block" for="background_image">Image de la page</label>
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="upload-container">
                                            <input type="file" name="background_image" id="background_image"
                                                class="form-control" accept="image/*"
                                                onchange="previewImage(this, 'background_image_preview')" />
                                        </div>
                                        <img id="background_image_preview" src="{{ asset($record->background_image) }}"
                                            class="rounded"
                                            style="width: 60px; height: 60px; display: {{ $record->background_image ? 'block' : 'none' }}"
                                            onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg=='">
                                    </div>
                                    @error('background_image')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('category.icon_image.update')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label d-block" for="icon_image">Image d'accueil</label>
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="upload-container">
                                            <input type="file" name="icon_image" id="icon_image" class="form-control"
                                                accept="image/*" onchange="previewImage(this, 'icon_image_preview')" />
                                        </div>
                                        <img id="icon_image_preview" src="{{ asset($record->icon_image) }}" class="rounded"
                                            style="width: 60px; height: 60px; display: {{ $record->icon_image ? 'block' : 'none' }}"
                                            onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg=='">
                                    </div>
                                    @error('icon_image')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('category.portrait_image.update')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label d-block" for="portrait_image">Image portrait</label>
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="upload-container">
                                            <input type="file" name="portrait_image" id="portrait_image" class="form-control"
                                                accept="image/*" onchange="previewImage(this, 'portrait_image_preview')" />
                                        </div>
                                        <img id="portrait_image_preview" src="{{ asset($record->portrait_image) }}"
                                            class="rounded"
                                            style="width: 60px; height: 60px; display: {{ $record->portrait_image ? 'block' : 'none' }}"
                                            onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFOUVDRUYiLz48cGF0aCBkPSJNMjAgMjBINDBWNDBIMjBWMjBaIiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIvPjwvc3ZnPg=='">
                                    </div>
                                    @error('portrait_image')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                    </div>

                    <div class="row g-3">
                        <h6 class="fw-bold py-3 mb-2">
                            <i class="bx bx-info-circle text-primary me-2"></i>
                            Informations générales
                        </h6>

                        @can('category.name.update')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $record->name) }}" />
                                    @error('name')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('category.link.update')
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="link">Lien <span class="text-danger">*</span></label>
                                    <input type="text" name="link" id="link" class="form-control"
                                        value="{{ old('link', $record->link) }}" />
                                    @error('link')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan



                        @can('category.short_description.update')
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="short_description">Description courte</label>
                                    <textarea name="short_description" id="short_description" class="form-control" rows="2">{{ old('short_description', $record->short_description) }}</textarea>
                                    @error('short_description')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                    </div>
                    @can('category.description.update')
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $record->description) }}</textarea>
                                @error('description')
                                    <span class="helper-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endcan

                    <hr class="my-4 mx-n4" />

                    <div class="pt-4 d-flex justify-content-between">
                        <div>
                            <button type="reset" class="btn btn-label-secondary me-2">
                                <i class="bx bx-reset me-1"></i>
                                Réinitialiser
                            </button>
                            <a href="{{ route('category.index') }}" class="btn btn-label-secondary">
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

    <script type="text/javascript">
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
@stop
