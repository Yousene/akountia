@extends($layout)
@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
<style>
    .file-upload-container {
        position: relative;
    }

    .file-preview {
        padding: 15px;
        border: 2px dashed #e3e6f0;
        border-radius: 8px;
        background-color: #f8f9fa;
        text-align: center;
    }

    .preview-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .file-info {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .existing-file .alert {
        margin-bottom: 10px;
    }
</style>
@stop
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="py-3 mb-4">Gestion des {projetId}s</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('{projetId}.index') }}">Liste des {projetId}s</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">
        <h5 class="card-header"></h5>
        <form class="card-body" method="POST" action="{{ route('{projetId}.update', ['{projetId}' => $record->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('Put')
            <div class="row g-3">
                {formTypes}

                <!--updates_fields-->
            </div>
            <hr class="my-4 mx-n4" />
            <div class="pt-4 float-end">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
            </div>
            <div class="pt-4 float-start">
                <button type="reset" class="btn btn-label-secondary">Vider</button>
                <a href="{{ route('{projetId}.index') }}" class="btn btn-label-secondary">Retour</a>
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
            time_24hr:true
        });
    });

    // Fonction pour prévisualiser les fichiers
    function previewFile(input, fieldId) {
        const file = input.files[0];
        const previewDiv = document.getElementById('preview-' + fieldId);
        const imgPreview = document.getElementById('img-preview-' + fieldId);
        const fileInfo = document.getElementById('file-info-' + fieldId);

        if (file) {
            previewDiv.style.display = 'block';

            // Afficher les informations du fichier
            const fileName = fileInfo.querySelector('.file-name');
            const fileSize = fileInfo.querySelector('.file-size');
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);

            // Preview pour les images
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imgPreview.style.display = 'none';
            }
        }
    }

    // Fonction pour effacer la preview
    function clearPreview(fieldId) {
        const input = document.getElementById(fieldId);
        const previewDiv = document.getElementById('preview-' + fieldId);
        const imgPreview = document.getElementById('img-preview-' + fieldId);

        input.value = '';
        previewDiv.style.display = 'none';
        imgPreview.src = '';
        imgPreview.style.display = 'none';
    }

    // Fonction pour formater la taille du fichier
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>
@stop
