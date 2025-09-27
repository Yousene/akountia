@extends($layout)
@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

@stop
@section('content')

<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="py-3 mb-4">Gestion des utilisateurs</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('user.index') }}">Liste des utilisateurs</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">
        <h5 class="card-header"></h5>
        <form class="card-body" method="POST" action="{{ route('apparence_update',['apparence'=>$record->id]) }}" id="formValidationUser">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="layout">Layout</label>
                    <select name='layout' id='layout' class="select2 form-control" data-allow-clear="true">
                        <option value="horizontal" {{($record->layout == 'horizontal') ? 'selected' : ''}}> Horizontal </option>
                        <option value="vertical" {{($record->layout == 'vertical') ? 'selected' : ''}}> Vertical </option>
                    </select>
                    @error('layout')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="label">Libellé</label>
                    <input type="text" name="label" id="label" class="form-control" placeholder="Libellé" value="{{ old('label', $record->label) }}" />
                    @error('label')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="title">Titre</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Libellé" value="{{ old('title', $record->title) }}" />
                    @error('title')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="logo_titre">Titre du Logo</label>
                    <input type="text" name="logo_titre" id="logo_titre" class="form-control" placeholder="Titre du Logo" value="{{ old('logo_titre', $record->logo_titre) }}" />
                    @error('logo_titre')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="logo">Logo</label>
                    <input type="text" name="logo" id="logo" class="form-control" placeholder="Logo" value="{{ old('logo', $record->logo) }}" />
                    @error('logo')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="logo_home">Logo Accueil</label>
                    <input type="text" name="logo_home" id="logo_home" class="form-control" placeholder="Logo Accueil" value="{{ old('logo_home', $record->logo_home) }}" />
                    @error('logo_home')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="couleur_header">Couleur header</label>
                    <input type="text" name="couleur_header" id="couleur_header" class="form-control" placeholder="Logo Accueil" value="{{ old('couleur_header', $record->couleur_header) }}" />
                    @error('couleur_header')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="couleur_sidebar">Couleur sidebar</label>
                    <input type="text" name="couleur_sidebar" id="couleur_sidebar" class="form-control" placeholder="Logo Accueil" value="{{ old('couleur_sidebar',$record->couleur_sidebar) }}" />
                    @error('couleur_sidebar')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="couleur_sidebar_logo">Couleur sidebar logo</label>
                    <input type="text" name="couleur_sidebar_logo" id="couleur_sidebar_logo" class="form-control" placeholder="Couleur sidebar logo" value="{{ old('couleur_sidebar_logo',$record->couleur_sidebar_logo) }}" />
                    @error('couleur_sidebar_logo')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="couleur_menu_actif">Couleur menu actif</label>
                    <input type="text" name="couleur_menu_actif" id="couleur_menu_actif" class="form-control" placeholder="Couleur menu actif" value="{{ old('couleur_menu_actif',$record->couleur_menu_actif) }}" />
                    @error('couleur_menu_actif')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="statut">Statut</label>
                    <select name='statut' id='statut' class="select2 form-control" data-allow-clear="true">
                        <option value=''></option>
                        <option value="1" {{($record->statut == '1') ? 'selected' : ''}}> Oui </option>
                        <option value="0" {{($record->statut == '0') ? 'selected' : ''}}> Non </option>
                    </select>
                    @error('statut')
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
                <a href="{{ route('apparence_list') }}" class="btn btn-label-secondary">Retour</a>
            </div>
        </form>
    </div>
</div>
@stop
@section('js')
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/js/forms-selects.js"></script>
@stop
