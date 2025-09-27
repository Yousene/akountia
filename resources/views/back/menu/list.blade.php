@extends($layout)
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="py-3 mb-4">Gestion des menus </h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('permission.index') }}">Liste des Menus</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Role cards -->
    <div class="row g-4 justify-content-end">
        <div class="col-md-3 text-end">
            <button data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn btn-primary mb-3 text-nowrap add-new-role">
                Ajouter Nouveau Menu
            </button>
        </div>
    </div>
    <!--/ Role cards -->
    <!-- Add Menu Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="role-title">Ajouter nouveau menu</h3>
                        <p>remplisser le formulaire</p>
                    </div>
                    <!-- Add role form -->
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
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Retour
                            </button>
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Menu Modal -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <h5 class="card-header">Glisser pour ajuster les menus </h5>
                <div class="card-body">
                    <div class="list-group col nested-sortable">
                        @foreach ($topLevelItems as $topLevelItem)
                        <div id="list-group-item" data-id="{{$topLevelItem->id}}" class="list-group-item nested-1 ">
                            <i class="tf-icons bx bx-{{$topLevelItem->icon}}"></i>{{$topLevelItem->titre}}
                            <a href="{{route('menu_update',['menu'=> $topLevelItem->id ])}}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                            <div class="list-group nested-sortable">
                                @if (isset($nestedItems[$topLevelItem->id]))
                                @foreach ($nestedItems[$topLevelItem->id] as $nestedItem)
                                <div data-id="{{$nestedItem->id}}" id="list-group-item" class="list-group-item nested-1 col-md-6">
                                    <i class="tf-icons bx bx-{{$nestedItem->icon}}"></i>{{$nestedItem->titre}}
                                    <a href="{{route('menu_update',['menu'=> $nestedItem->id ])}}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>

                                    <div class="list-group nested-sortable">
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
@section('js')
<script src="/assets/vendor/libs/sortablejs/sortable.js">
</script>
<script>
    const exampleModal = document.getElementById('editMenuModal')
    exampleModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const recipient = button.getAttribute('data-bs-whatever')
        console.log(recipient)
        const modalBodyInput = exampleModal.querySelector('#editIframe')
        modalBodyInput.setAttribute("src", "/menu/update/" + recipient)
    })
</script>
<script>
    function logUpdatedArray(originalData) {
        const renderedDivs = document.querySelectorAll('#list-group-item');
        const newData = Array.from(renderedDivs).map((div, index) => {
            const id = div.getAttribute('data-id');
            const originalItem = originalData.find(obj => obj.id === parseInt(id));
            if (originalItem) {
                const parentMenu = div.parentElement.closest('#list-group-item');
                const parentId = parentMenu ? parentMenu.getAttribute('data-id') : null;
                return {
                    id,
                    parent_id: parentId,
                    ordre: index + 1
                };
            }
        });
        fetch("{{route('update_menus_drag')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(newData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server Response:', data);
                window.location.href = "{{route('menu_list')}}"
            })
            .catch(error => console.error('Error:', error));
    }

    const originalData = @json($originalData);
    document.querySelectorAll('.nested-sortable').forEach(nestedSortable => {
        new Sortable(nestedSortable, {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 1,
            onEnd: function() {
                logUpdatedArray(originalData);
            }
        });
    });
</script>
@stop