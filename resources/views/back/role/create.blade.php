@extends($layout)

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="py-3 mb-4">Gestion des roles</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('role_list') }}">Liste des roles</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card mb-4">
        <h5 class="card-header"></h5>
        <form class="card-body" method="POST" action="{{ route('role_create') }}" id="formValidationUser">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="role">Role</label>
                    <input type="text" name="role" id="role" class="form-control" placeholder="Role" value="{{old('role')}}" />
                    @error('role')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="label">Libellé</label>
                    <input type="text" name="label" id="label" class="form-control" placeholder="Libellé" value="{{old('label')}}" />
                    @error('label')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="select2Basic" class="form-label">Couleur</label>
                    <select id="select2Basic" class="select2 form-select" name="color" data-allow-clear="true">
                        <option value="">Selectionner une couleur</option>
                        <option value="primary" class="text-white bg-primary">Bleu</option>
                        <option value="info" class="text-white bg-info">Bleu Ciel</option>
                        <option value="danger" class="text-white bg-danger">Rouge</option>
                        <option value="success" class="text-white bg-success">Vert</option>
                        <option value="warning" class="text-white bg-warning">Jaune</option>
                        <option value="secondary" class="text-white bg-secondary">Gris</option>
                        <option value="light" class="text-dark bg-light">Blanc</option>
                        <option value="dark" class="text-white bg-dark">Noir</option>
                    </select>
                    @error('color')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="desc">Description</label>
                    <textarea name="desc" id="desc" class="form-control" placeholder="Description">{{old('desc')}}</textarea>
                    @error('desc')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row g-3 mt-5">
                <div class="col-xl-12">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-functionnalities" aria-controls="navs-justified-functionnalities" aria-selected="true">
                                    <i class="tf-icons bx bx-list-check me-1 fs-3"></i> Liste des fonctionnalités
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-permissions" aria-controls="navs-justified-permissions" aria-selected="false">
                                    <i class="tf-icons bx bx-user-check me-1 fs-3"></i> Liste des permissions
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-justified-functionnalities" role="tabpanel">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select multiple="multiple" size="10" name="fonctionnalites[]" id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                            @foreach ($fonctionnalites as $fonctionnalite)
                                            <option value="{{ $fonctionnalite->id }}">{{ $fonctionnalite->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-justified-permissions" role="tabpanel">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select multiple="multiple" size="10" name="permissions[]" id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4 mx-n4" />
            <div class="pt-4 float-end">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
            </div>
            <div class="pt-4 float-start">
                <button type="reset" class="btn btn-label-secondary">Vider</button>
                <a href="{{ route('role_list') }}" class="btn btn-label-secondary">Retour</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
{{-- <link rel="stylesheet" type="text/css" href="/assets/vendors/duallistbox/bootstrap.min.css">--}}
{{-- <link rel="stylesheet" type="text/css" href="/assets/vendors/duallistbox/bootstrap-duallistbox.css">--}}
<script src="/assets/vendors/duallistbox/jquery.bootstrap-duallistbox.js"></script>
<style>
    .nav-tabs .nav-link.active {
        background-color: #26344661;
    }

    .select-dropdown {
        display: none !important;
    }

    .info {
        display: none !important;
    }

    .info-container {
        display: none !important;
    }
</style>
<script>
    $(document).ready(function() {
        $('select[name="fonctionnalites[]"]').bootstrapDualListbox();
        $('select[name="permissions[]"]').bootstrapDualListbox();
    });
</script>
@stop
