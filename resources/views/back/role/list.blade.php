@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
@stop
@section('content')
    <div class="flex-grow-1 container-p-y container-fluid">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Gestion des roles</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('role_list') }}">Liste des roles</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Role cards -->
        <div class="row g-4 mb-5">
            @foreach ($records as $record)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="fw-normal">Au total, il y a {{ count($record->users) }} utilisateurs.</h6>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    @foreach ($record->users as $user)
                                        @php
                                            $initial = mb_substr($user->name, 0, 1) . mb_substr($user->first_name, 0, 1);
                                            $photo = $user->photo ? "<img src=\"/uploads/photos/$user->photo\" alt=\"$user->photo\" class=\"rounded-circle\">" : "<span class=\"avatar-initial rounded-circle bg-label-primary\">$initial</span>";
                                        @endphp
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            class="avatar avatar-sm pull-up"
                                            title="{{ $user->name }} {{ $user->first_name }}">
                                            {!! $photo !!}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="role-heading">
                                    <h4 class="mb-1">{{ $record->label }}</h4>
                                    <a href="{{ route('role_update', ['role' => $record->id]) }}"
                                        class="role-edit-modal"><small>Modifier</small></a>
                                </div>
                                <!-- <a href="javascript:void(0);" class="text-muted"><i class="bx bx-copy"></i></a> -->
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="../../assets/img/illustrations/sitting-girl-with-laptop-light.png"
                                    class="img-fluid" alt="Image" width="120"
                                    data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                                    data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png" />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <a href="{{ route('role_create') }}" class="btn btn-primary mb-3 text-nowrap add-new-role">
                                    Ajouter nouveau rôle
                                </a>
                                <p class="mb-0">Ajoutez le rôle s'il n'existe pas déjà.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Role cards -->
        <!-- Striped Rows -->
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>LIBELLÉ</th>
                            <th>Users</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($records as $record)
                            <tr>
                                <td>
                                    <i class="fas fa-users fa-lg text-{{ $record->color }} me-3"></i>
                                    <span class="fw-medium">{{ $record->role }}</span>
                                </td>
                                <td><span class="badge bg-label-{{ $record->color }} me-1">{{ $record->label }}</span>
                                </td>
                                <td>
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                        @foreach ($record->users as $user)
                                            @php
                                                $initial = mb_substr($user->name, 0, 1) . mb_substr($user->first_name, 0, 1);
                                                $photo = $user->photo ? "<img src=\"/uploads/photos/$user->photo\" alt=\"$user->photo\" class=\"rounded-circle\">" : "<span class=\"avatar-initial rounded-circle bg-label-primary\">$initial</span>";
                                            @endphp
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                                class="avatar avatar-xs pull-up"
                                                title="{{ $user->name }} {{ $user->first_name }}">
                                                {!! $photo !!}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a class="dropdown-item" href="{{ route('role_update', ['role' => $record->id]) }}"><i
                                            class="bx bx-edit-alt me-1"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@section('js')

@stop
