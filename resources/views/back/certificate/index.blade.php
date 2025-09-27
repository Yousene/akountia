@extends('layouts.back')

@section('content')
    <style>
        .card-stats-title .material-icons {
            font-size: 60px !important;
        }
    </style>

    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Obtenir un certificat de formation</h4>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form id="certificateForm">
                    <div class="row g-3">
                        @can('certificate.name.create')
                            <div class="col-md-6">
                                <label class="form-label" for="name">Nom complet</label>
                                <input type="text" class="form-control" id="name" name="Name"
                                    placeholder="Abdelkader Asri" required minlength="3" maxlength="60">
                                <small class="text-muted">Entrez votre nom complet tel qu'il apparaîtra sur le
                                    certificat</small>
                                @error('name')
                                    <span class="helper-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endcan

                        @can('certificate.formation.create')
                            <div class="col-md-6">
                                <label class="form-label" for="formation">Formation</label>
                                <input type="text" class="form-control" id="formation" name="formation" required
                                    placeholder="Nom de la formation">
                                @error('formation')
                                    <span class="helper-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endcan

                        @can('certificate.session_start.create')
                            <div class="col-md-6">
                                <label class="form-label" for="session">Date de début de la session</label>
                                <input type="date" class="form-control" id="session" name="session" required>
                                @error('session')
                                    <span class="helper-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endcan

                        @can('certificate.session_end.create')
                            <div class="col-md-6">
                                <label class="form-label" for="session2">Date de fin de la session</label>
                                <input type="date" class="form-control" id="session2" name="session2" required>
                                @error('session2')
                                    <span class="helper-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endcan

                        @can('certificate.date.create')
                            <div class="col-md-6">
                                <label class="form-label" for="certifdate">Date de l'attestation</label>
                                <input type="date" class="form-control" id="certifdate" name="certifdate" required>
                                @error('certifdate')
                                    <span class="helper-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endcan
                    </div>

                    <hr class="my-4">

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            Générer le certificat
                            <i class="bx bx-send ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@stop

@section('js')
    <script src="https://unpkg.com/pdf-lib@1.4.0"></script>
    <script src="https://unpkg.com/@pdf-lib/fontkit@0.0.4"></script>
    <script src="{{ asset('assets/js/certif/FileSaver.js') }}"></script>
    <script src="{{ asset('assets/js/certif/index.js') }}"></script>
@stop

@section('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #d9dee3;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@stop
