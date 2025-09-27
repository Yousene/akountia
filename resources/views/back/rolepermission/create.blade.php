@extends($layout)
@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />

@stop
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="py-3 mb-4">Gestion des rolepermissions</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('rolepermission.index') }}">Liste des rolepermissions</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">
        <h5 class="card-header"></h5>
        <form class="card-body" method="POST" action="{{ route('rolepermission.store') }}">
            @csrf
            <div class="row g-3">
                    <div class="col-md-6">
        <label class="form-label" for="role_id">Role</label>
        <select name="role_id" id="role_id" class="select2 form-control" data-allow-clear="true">
    @foreach ($roleRecords as $row)
    <option class="option" {{ $row->id == old('role_id') ? 'selected' : '' }} value="{{ $row->id }}"> {{ $row->label }}</option>
    @endforeach
</select>
        @error('role_id')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>    <div class="col-md-6">
        <label class="form-label" for="permission_id">Permission</label>
        <select name="permission_id" id="permission_id" class="select2 form-control" data-allow-clear="true">
    @foreach ($permissionRecords as $row)
    <option class="option" {{ $row->id == old('permission_id') ? 'selected' : '' }} value="{{ $row->id }}"> {{ $row->name }}</option>
    @endforeach
</select>
        @error('permission_id')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
            </div>
            <hr class="my-4 mx-n4" />
            <div class="pt-4 float-end">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
            </div>
            <div class="pt-4 float-start">
                <button type="reset" class="btn btn-label-secondary">Vider</button>
                <a href="{{ route('rolepermission.index') }}" class="btn btn-label-secondary">Retour</a>
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
            noCalendar: true
        });
    });
</script>
@stop
