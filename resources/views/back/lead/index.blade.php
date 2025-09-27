@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <style>
        .dt-buttons .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible mb-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Gestion des leads</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('lead.index') }}">Liste des prospects</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="dt-column-search table table-bordered border-top">
                    <thead>
                        <tr>
                            <th>Type d'inscriptions</th>
                            <th>Nom complet</th>
                            <th>Entreprise</th>
                            <th>Email</th>
                            <th>Ville</th>
                            <th>Formation</th>
                            <th>Catégorie</th>
                            <th>Téléphone</th>
                            <th>Statut</th>
                            <th>Mis à jour</th> <!-- Ajout de la colonne updated_at -->
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
        // Récupérer les statuts depuis le contrôleur
        const statuts = @json(\App\Models\Statut::where('deleted', '0')->get(['id', 'label']));
        // Définir les types d'inscription
        const types = ['Particulier', 'Entreprise'];
        // Définir les villes
        const cities = ['Casablanca', 'Rabat', 'Reste du monde'];

        function openSuppModal(id) {
            $("#delId").val(id);
        }

        function suppRecord() {
            var id = $("#delId").val();
            $.ajax({
                url: '/lead/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    if (result.success) {
                        alert(result.message);
                        window.location.replace("/lead");
                    } else {
                        alert("Erreur lors de la suppression!");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $(document).ready(function() {
            'use strict';
            var dt_filter_table = $('.dt-column-search');
            var dt_filter = dt_filter_table.DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('lead.data') }}",
                columns: [{
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'course',
                        name: 'course'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'statut',
                        name: 'statut'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ],
                language: {
                    url: '/assets/vendors/data-tables/i18n/fr_fr.json'
                },
                dom: '<"card-header"<"head-label text-center"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 25,
                lengthMenu: [5, 10, 25, 50, 75, 100],
                buttons: [{
                        extend: 'collection',
                        className: 'btn btn-label-primary dropdown-toggle me-2',
                        text: '<i class="bx bx-show me-1"></i>Exporter',
                        buttons: [{
                                extend: 'print',
                                text: '<i class="bx bx-printer me-1"></i>Imprimer',
                                className: 'dropdown-item'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="bx bx-file me-1"></i>Csv',
                                className: 'dropdown-item'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="bx bx-file me-1"></i>Excel',
                                className: 'dropdown-item'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
                                className: 'dropdown-item'
                            },
                            {
                                extend: 'copy',
                                text: '<i class="bx bx-copy me-1"></i>Copier',
                                className: 'dropdown-item'
                            }
                        ]
                    },
                    {
                        text: '<i class="bx bx-plus me-1"></i>Ajouter',
                        className: 'create-new btn btn-primary',
                        action: function(e, dt, node, config) {
                            window.location.href = '{{ route('lead.create') }}';
                        }
                    }
                ]
            });

            // Clone the original header row
            $('.dt-column-search thead tr').clone(true).addClass('d-none d-sm-table-row').appendTo(
                '.dt-column-search thead');
            // Remove the first and the last th from the cloned row
            $('.dt-column-search thead tr:eq(1) th:first').remove();
            $('.dt-column-search thead tr:eq(1) th:last').html("");

            $('.dt-column-search thead tr:eq(1) th').each(function(i) {
                if (i === 0) { // Type d'inscriptions
                    let options = '<option value="">Tous</option>';
                    types.forEach(type => {
                        options += `<option value="${type}">${type}</option>`;
                    });

                    $(this).html(`
                        <div class="input-group input-group-merge">
                            <select class="form-select" id="type-filter">
                                ${options}
                            </select>
                        </div>
                    `);

                    $('select', this).on('change', function() {
                        if (dt_filter.column(i).search() !== this.value) {
                            dt_filter.column(i).search(this.value).draw();
                        }
                    });
                } else if (i === 4) { // Ville (index 4)
                    let options = '<option value="">Toutes</option>';
                    cities.forEach(city => {
                        options += `<option value="${city}">${city}</option>`;
                    });

                    $(this).html(`
                        <div class="input-group input-group-merge">
                            <select class="form-select" id="city-filter">
                                ${options}
                            </select>
                        </div>
                    `);

                    $('select', this).on('change', function() {
                        if (dt_filter.column(i).search() !== this.value) {
                            dt_filter.column(i).search(this.value).draw();
                        }
                    });
                } else if (i === 8) { // Statut
                    let options = '<option value="">Tous</option>';
                    statuts.forEach(statut => {
                        options += `<option value="${statut.label}">${statut.label}</option>`;
                    });

                    $(this).html(`
                        <div class="input-group input-group-merge">
                            <select class="form-select" id="status-filter">
                                ${options}
                            </select>
                        </div>
                    `);

                    $('select', this).on('change', function() {
                        if (dt_filter.column(i).search() !== this.value) {
                            dt_filter.column(i).search(this.value).draw();
                        }
                    });
                } else {
                    $(this).html(
                        '<div class="input-group input-group-merge flex-nowrap">' +
                        '<span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>' +
                        '<input type="text" class="form-control" placeholder="Rechercher" />' +
                        '</div>'
                    );
                    $('input', this).on('keyup change', function() {
                        if (dt_filter.column(i).search() !== this.value) {
                            dt_filter.column(i).search(this.value).draw();
                        }
                    });
                }
            });
            $('.head-label').html('<h5 class="card-title mb-0">DataTable with Buttons</h5>');

            // Initialisation des tooltips après le chargement des données
            dt_filter.on('draw.dt', function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            });
        });
    </script>
@stop
