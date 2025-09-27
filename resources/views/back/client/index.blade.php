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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible mb-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">
                    <i class="bx bx-group text-primary me-2"></i>
                    Gestion des clients
                </h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">
                                <i class="bx bx-home-alt text-primary me-1"></i>
                                Accueil
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('client.index') }}">Liste des clients</a>
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
                            <th class="text-nowrap">Nom</th>
                            <th class="text-nowrap">Lien</th>
                            <th class="text-nowrap">Icon</th>
                            <th class="text-nowrap">Image</th>
                            <th class="text-nowrap">Prioritaire</th>
                            <th class="text-nowrap">Action</th>
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
                url: '/client/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    if (result.success) {
                        alert(result.message);
                        window.location.replace("/client");
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
                scrollX: true,
                responsive: false,
                ajax: "{{ route('client.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'link',
                        name: 'link'
                    },
                    {
                        data: 'icon_image',
                        name: 'icon_image'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'is_priority',
                        name: 'is_priority',
                        render: function(data, type, row) {
                            return `<div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    onchange="updatePriority(${row.id}, this.checked)"
                                    ${data ? 'checked' : ''}>
                            </div>`;
                        }
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
                                text: '<i class="bx bx-printer me-1" ></i>Imprimer',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4]
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="bx bx-file me-1" ></i>Csv',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4]
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="bx bx-file me-1" ></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4]
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4]
                                }
                            },
                            {
                                extend: 'copy',
                                text: '<i class="bx bx-copy me-1" ></i>Copier',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4]
                                }
                            }
                        ]
                    },
                    {
                        text: '<i class="bx bx-plus me-1"></i> <span class="d-none d-lg-inline-block">Ajouter</span>',
                        className: 'create-new btn btn-primary',
                        action: function(e, dt, node, config) {
                            window.location.href = '{{ route('client.create') }}';
                        }
                    }
                ],
            });

            // Clone the original header row
            $('.dt-column-search thead tr').clone(true).addClass('d-none d-sm-table-row').appendTo(
                '.dt-column-search thead');
            // Remove the first and the last th from the cloned row
            $('.dt-column-search thead tr:eq(1) th:first').remove();
            $('.dt-column-search thead tr:eq(1) th:last').html("");

            $('.dt-column-search thead tr:eq(1) th:not(:last)').each(function(i) {
                $(this).html(
                    '<div class="input-group input-group-merge"><span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span><input type="text" class="form-control" placeholder="..." aria-label="..." aria-describedby="basic-addon-search31"></div>'
                );
                $('input', this).on('keyup change', function() {
                    if (dt_filter.column(i).search() !== this.value) {
                        dt_filter.column(i).search(this.value).draw();
                    }
                });
            });
            $('.head-label').html('<h5 class="card-title mb-0">DataTable with Buttons</h5>');

            // Initialisation des tooltips après le chargement des données
            dt_filter.on('draw.dt', function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            });
        });
    </script>
@stop
