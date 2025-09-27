@extends($layout)

@section('content')
<div id="breadcrumbs-wrapper" class="breadcrumbs-bg-image gradient-45deg-blue-grey-blue">
    <!-- Search for small screen-->
    <div class="container">
        <div class="row">
            <div class="col s12 m6 l6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Gestion des quickyprojects</span></h5>
            </div>
            <div class="col s12 m6 l6 right-align-md">
                <ol class="breadcrumbs mb-0 mt-0">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('quickyproject.index')}}">Liste des quickyprojects</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <div class="container">
            <div class="section">
                <form method="POST" action="{{route('quickyproject.store')}}">
                    @csrf
                    <br>
                    <div class="card">
                        <div class="card-panel">
                            <div class="row">
                                <div class="col s12 m12">
                                    <div class="row">

                                        <div class="col s12 input-field">
                                            <input id="name" name="name" value="{{old('name')}}" autocomplete="off"
                                            readonly onfocus="this.removeAttribute('readonly');" type="text">
                                            <label for="name"> Nom </label>
                                            @error('name')
                                                <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="id_project" name="id_project" value="{{old('id_project')}}" autocomplete="off"
                                            readonly onfocus="this.removeAttribute('readonly');" type="text">
                                            <label for="id_project"> Id du projet </label>
                                            @error('id_project')
                                                <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12">
                                    <div class="col s12 display-flex justify-content-end mt-3">
                                        <a href="{{route('quickyproject.index')}}"><button type="button"
                                                class="btn btn-light">Retour </button></a>
                                        <button type="submit" class="btn indigo" style="margin-left: 1rem;">
                                            Enregistrer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
