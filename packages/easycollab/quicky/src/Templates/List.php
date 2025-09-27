@extends($layout)
@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
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
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive text-nowrap pt-0">
            <table class="dt-column-search table  border-top">
                <thead>
                    <tr>
                        <th></th>
                        {th}
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal to delete record -->
    <div class="col-lg-4 col-md-6">
        <!-- Modal -->
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Confirmation de suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3 text-danger">
                                <div>
                                    Êtes-vous sûr de vouloir supprimer ?
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="delId" id="delId">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <a href="#!" class="btn btn-danger" onclick="suppRecord()">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script type="text/javascript">
    function openSuppModal(id) {
        $("#delId").val(id);
    }

    function suppRecord() {
        var id = $("#delId").val();
        $.ajax({
            url: '/{projetId}/' + id,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                if (result.success) {
                    alert(result.message);
                    window.location.replace("/{projetId}");
                } else {
                    alert("Erreur lors de la suppression!");
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    {serverSide}
</script>
@stop
