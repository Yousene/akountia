@extends($layout)
@section('content')
<div id="breadcrumbs-wrapper" class="breadcrumbs-bg-image gradient-45deg-blue-grey-blue">
    <!-- Search for small screen-->
    <div class="container">
        <div class="row">
            <div class="col s12 m6 l6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Gestion des ressources</span></h5>
            </div>
            <div class="col s12 m6 l6 right-align-md">
                <ol class="breadcrumbs mb-0 mt-0">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('ressource_list')}}">Liste des ressources</a>
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
                <br>
                <div class="list-table" id="app">
                    <div class="card">
                        <div class="card-content">
                            <!-- datatable start -->
                            <div class="responsive-table">
                                <table id="list-datatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>

                                            <th> Nom </th>
                                            <th> Description </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $record)
                                        <tr>

                                            <td> {{ $record->name }} </td>
                                            <td> {{ $record->desc }} </td>
                                            <td>
                                                <a href="{{route('ressource_update', ['ressource'=>$record->id])}}"><i
                                                        class="material-icons tooltipped" data-position="top"
                                                        data-tooltip="Modifier">edit</i></a>
                                                <a  href="#!" onclick="openSuppModal({{$record->id}})"><i class="material-icons tooltipped" style="color: #c10027;" data-position="top"
                                            data-tooltip="Supprimer">delete</i></a>
                                            </td>
                                        </tr>
                                        @endforeach

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a href="{{route('ressource_create')}}" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow"><i class="material-icons">add</i></a></div>
    </div>
</div>

<div id="delete_modal" class="modal">
    <div class="modal-content">
        <h4> Confirmation de suppression</h4>
        <div>
            Êtes-vous sûr de vouloir supprimer ?
        </div>
        <input type="hidden" name="delId" id="delId">
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn grey">Annuler</a>
        <a href="#!" class="waves-effect waves-green btn red" onclick="suppRecord()">Supprimer</a>
    </div>
</div>
@stop
@section('js')
<script>
    function openSuppModal(id) {
        $("#delId").val(id);
        $('#delete_modal').modal('open');
    }
    function suppRecord() {
        window.location.replace("/ressource/delete/"+$("#delId").val());
    }
    $(document).ready(function() {
        $('.modal').modal();
    });
</script>
@stop
