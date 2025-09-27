@extends($layout)
@section('content')
<style>
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
<div class="row">
    <div class="col s12">
        <div class="container">
            <div class="section">

                <form method="POST" action="{{route('fonctionnalite_update', ['fonctionnalite' => $record->id])}}">
                    @csrf
                    <br>
                    @if (Session::has('success'))
                    <div class="card-alert card green">
                        <div class="card-content white-text">
                            <p>{{ Session::get('success') }} </p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-panel">
                            <div class="row">
                                <div class="col s12 m12">
                                    <div class="row">

                                        <div class="col s6 input-field">
                                            <input id="name" name="name" value="{{old('name', $record->name)}}"
                                                autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"
                                                type="text">
                                            <label for="name"> Nom </label>
                                            @error('name')
                                            <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col s6 input-field">
                                            <textarea d="desc" name="desc"
                                                class="materialize-textarea">{{old('desc', $record->desc)}}</textarea>
                                            <label for="desc"> Description </label>
                                            @error('desc')
                                            <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col s12 input-field">
                                            <select multiple="multiple" size="10" name="routes[]">
                                                @foreach ($routes as $route)
                                                @if( strlen($route->getName())>1 )
                                                <option
                                                    {{ in_array($route->getName(), $relatedRoutes) ? "selected" : '' }}
                                                    value="{{ $route->getName() }}">{{ $route->getName() }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <label for="label" style="font-size: 1rem;"> Liste des routes :
                                            </label>
                                        </div>

                                        <div class="col s12 input-field">
                                            <select multiple="multiple" size="10" name="ressources[]">
                                                @foreach ($ressources as $ressource)
                                                <option
                                                    {{ in_array($ressource->id, $record->ressources()->allRelatedIds()->toArray()) ? "selected" : '' }}
                                                    value="{{ $ressource->id }}">{{ $ressource->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="label" style="font-size: 1rem;"> Liste des ressources :
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12">
                                    <div class="col s12 display-flex justify-content-end mt-3">
                                        <a href="{{route('fonctionnalite_list')}}"><button type="button"
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
@section('js')
<link rel="stylesheet" type="text/css" href="/assets/vendors/duallistbox/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/duallistbox/bootstrap-duallistbox.css">
<script src="/assets/vendors/duallistbox/jquery.bootstrap-duallistbox.js"></script>


<script>
$(document).ready(function() {
    $('select[name="ressources[]"]').bootstrapDualListbox();
    $('select[name="routes[]"]').bootstrapDualListbox();
});
</script>
@stop