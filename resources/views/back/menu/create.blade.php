@extends($layout)
@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

@stop
@section('content')

<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="py-3 mb-4">Gestion des menus</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('menu_list') }}">Liste des menus</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">
        <h5 class="card-header"></h5>
        <form class="card-body" method="POST" action="{{ route('menu_create') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="titre">Titre du menu</label>
                    <input type="text" name="titre" id="titre" class="form-control" placeholder="Prénom" value="{{ old('titre') }}" />
                    @error('titre')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="page">Page</label>
                    <select name="page" id="page" class="select2 form-select" data-allow-clear="true">
                        <option class='option' value='' selected></option>
                        @foreach ($routes as $route)
                        <option class='option' value='{{$route->getName()}}'>
                            {{$route->getName() ." (".$route->uri().") "}}
                        </option>
                        @endforeach
                    </select>
                    @error('page')
                    <span class="helper-text materialize-red-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="parent_menu">Menu Parent</label>
                    <select name="parent_menu" id="parent_menu" class="select2 form-select" data-allow-clear="true">
                        <option class='option' value='' selected></option>
                        @foreach ($menus as $row)
                        <option class='option' {{($row->id == old('parent_menu')) ? 'selected' : ''}} value='{{$row->id}}'> {{$row->titre}}</option>
                        @endforeach
                    </select>
                    @error('parent_menu')
                    <span class="helper-text materialize-red-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="icon">Icone</label>
                    <input type="text" name="icon" id="icon" class="form-control" placeholder="Icone" value="{{ old('icon') }}" />
                    @error('icon')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="ordre">Ordre</label>
                    <input type="text" name="ordre" id="ordre" class="form-control" placeholder="Ordre" value="{{ old('ordre') }}" />
                    @error('ordre')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="ressource">Ressource</label>
                    <select name="ressource" id="ressource" class="select2 form-select" data-allow-clear="true">
                        <option class='option' value='' selected></option>
                        @foreach ($ressources as $row)
                        <option class='option' {{($row->id == old('ressource')) ? 'selected' : ''}} value='{{$row->id}}'> {{$row->name}}</option>
                        @endforeach
                    </select>
                    @error('ressource')
                    <span class="helper-text materialize-red-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="desc">Description</label>
                    <input type="text" name="desc" id="desc" class="form-control" placeholder="Description" value="{{ old('desc') }}" />
                    @error('desc')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="statut">Visible</label>
                    <select name="statut" id="statut" class="select2 form-select" data-allow-clear="true">
                        <option value="1"> Oui </option>
                        <option value="0"> Non </option>
                    </select>
                    @error('statut')
                    <span class="helper-text materialize-red-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <hr class="my-4 mx-n4" />
            <div class="pt-4 float-end">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
            </div>
            <div class="pt-4 float-start">
                <button type="reset" class="btn btn-label-secondary">Vider</button>
                <a href="{{ route('menu_list') }}" class="btn btn-label-secondary">Retour</a>
            </div>
        </form>
    </div>
</div>
@stop
@section('js')
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/js/forms-selects.js"></script>
@stop
