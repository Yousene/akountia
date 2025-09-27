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
                <h4 class="py-3 mb-4">Gestion des reviews</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('review.index') }}">Liste des reviews</a>
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
                            <th class="text-nowrap">Nom et prénom</th>
                            <th class="text-nowrap">Entreprise</th>
                            <th class="text-nowrap">Poste occupé</th>
                            <th class="text-nowrap">Notation</th>
                            <th class="text-nowrap">Validation</th>
                            <th class="text-nowrap">Commentaire</th>
                            <th class="text-nowrap">Formation</th>
                            <th class="text-nowrap">Photo</th>
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
                url: '/review/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    if (result.success) {
                        alert(result.message);
                        window.location.replace("/review");
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
                ajax: "{{ route('review.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'rating',
                        name: 'rating'
                    },
                    {
                        data: 'validation',
                        name: 'validation'
                    },
                    {
                        data: 'comment',
                        name: 'comment'
                    },
                    {
                        data: 'course_id',
                        name: 'course_id'
                    },
                    {
                        data: 'picture',
                        name: 'picture'
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
                                    columns: [1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="bx bx-file me-1" ></i>Csv',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="bx bx-file me-1" ></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'copy',
                                text: '<i class="bx bx-copy me-1" ></i>Copier',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5, 6, 7]
                                }
                            }
                        ]
                    },
                    {
                        text: '<i class="bx bx-plus me-1"></i> <span class="d-none d-lg-inline-block">Ajouter</span>',
                        className: 'create-new btn btn-primary',
                        action: function(e, dt, node, config) {
                            window.location.href = '{{ route('review.create') }}';
                        }
                    }
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Détails de' + data[1];
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !== '' ?
                                    '<tr data-dt-row="' +
                                    col.rowIndex +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                }
            });
            // Clone the original header row
            $('.dt-column-search thead tr').clone(true).addClass('d-none d-sm-table-row').appendTo(
                '.dt-column-search thead');
            // Remove the first and the last th from the cloned row
            $('.dt-column-search thead tr:eq(1) th:first').remove();
            $('.dt-column-search thead tr:eq(1) th:last').html("");

            $('.dt-column-search thead tr:eq(1) th:not(:last)').each(function(i) {
                // Vérifier si c'est la colonne de validation
                if ($(this).index() === 4) { // Index 4 correspond à la colonne Validation
                    $(this).html(`
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                            <select class="form-select">
                                <option value="">Tous</option>
                                <option value="1">Validé</option>
                                <option value="0">Non validé</option>
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
                        '<div class="input-group input-group-merge"><span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span><input type="text" class="form-control" placeholder="..." aria-label="..." aria-describedby="basic-addon-search31"></div>'
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
