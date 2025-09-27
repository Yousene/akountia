@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
@stop
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Gestion des permissions</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('permission.index') }}">Liste des permissions</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row my-3">
            <form method="POST" action="{{ route('permissions.refresh') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Actualiser les Permissions</button>
            </form>
            @if (session('success'))
                <div class="col-md-4 d-block my-2">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                </div>
            @endif
        </div>
        <!-- Permission Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="datatables-permissions table border-top">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nom Permission</th>
                            <th>Assigné à</th>
                            <th>Date de creation</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script type="text/javascript">
        var dataTablePermissions = $('.datatables-permissions'),
            dt_permission,
            userList = 'app-user-list.html';

        // Users List datatable
        if (dataTablePermissions.length) {
            dt_permission = dataTablePermissions.DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('permission.data') }}", // JSON file to add data
                columns: [
                    // columns according to JSON
                    {
                        data: ''
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'assigned_to'
                    },
                    {
                        data: 'created_at'
                    },
                ],
                columnDefs: [{
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return '';
                    }
                }],
                order: [
                    [1, 'asc']
                ],
                language: {
                    sLengthMenu: '_MENU_',
                    search: 'Recherche',
                    searchPlaceholder: 'Recherche..'
                },
                // For responsive popup
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details of ' + data['name'];
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !==
                                    '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ?
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
        }
    </script>
@stop
