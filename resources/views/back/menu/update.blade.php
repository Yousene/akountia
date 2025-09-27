@extends($layout)
@section('content')
<div class="row">
    <div class="col s12">
        <div class="container">
            <div class="section">

                <form method="POST" action="{{route('menu_update', ['menu' => $record->id])}}">
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

                                        <div class="col s12 input-field">
                                            <input id="titre" name="titre" value="{{old('titre', $record->titre)}}"
                                                autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"
                                                type="text">
                                            <label for="titre"> Titre du menu </label>
                                            @error('titre')
                                            <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col s6 input-field">

                                            <select name='page' id='page' class="select2 browser-default">
                                                <option class='option' value=""></option>
                                                @foreach ($routes as $route)
                                                <option class='option' @if($route->getName() != "")
                                                    {{($route->getName() == old('page', $record->page)) ? 'selected' : ''}}
                                                    value='{{$route->getName()}}'>
                                                    {{$route->getName() ." (".$route->uri().") "}}</option>
                                                @endif
                                                @endforeach
                                            </select>

                                            <label for="page"> Page </label>
                                            @error('page')
                                            <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col s6 input-field">

                                            <select name='parent_menu' id='parent_menu' class="select2 browser-default">
                                                <option class='option' value='' selected></option>
                                                @foreach ($menus as $row)
                                                <option class='option'
                                                    {{($row->id == old('parent_menu', $record->parent_menu)) ? 'selected' : ''}}
                                                    value='{{$row->id}}'> {{$row->titre}}</option>
                                                @endforeach
                                            </select>
                                            <label for="parent_menu"> Menu parent </label>
                                            @error('parent_menu')
                                            <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col s6 input-field">
                                            <input id="ordre" name="ordre" value="{{old('ordre', $record->ordre)}}"
                                                autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"
                                                type="text">
                                            <label for="ordre"> Ordre </label>
                                            @error('ordre')
                                            <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col s6 input-field">
                                            <input id="icon" name="icon" value="{{old('icon', $record->icon)}}"
                                                autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"
                                                type="text">
                                            <label for="icon"> Icone </label>
                                            @error('icon')
                                            <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col s6 input-field">
                                            <select name='ressource' id='ressource' class="select2 browser-default">
                                                <option class='option' value='' selected></option>
                                                @foreach ($ressources as $row)
                                                <option class='option'
                                                    {{($row->id == old('ressource', $record->ressource)) ? 'selected' : ''}}
                                                    value='{{$row->id}}'> {{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <label for="roles"> Ressource </label>
                                            @error('roles')
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

                                        <div class="col s6 input-field">
                                            <select name='statut' id='statut' class="select2 browser-default">
                                                <option value="1" {{($record->statut == '1') ? 'selected' : ''}}> Oui
                                                </option>
                                                <option value="0" {{($record->statut == '0') ? 'selected' : ''}}> Non
                                                </option>
                                            </select> <label for="statut"> Visible</label>
                                            @error('statut')
                                            <span class="helper-text materialize-red-text">{{ $message }}</span>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12">
                                    <div class="col s12 display-flex justify-content-end mt-3">
                                        <button type="submit" class="btn indigo" style="margin-left: 1rem;">
                                            تسجيل</button>

                                        <a href="{{route('menu_list')}}"><button type="button"
                                                class="btn btn-light">رجوع </button></a>

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