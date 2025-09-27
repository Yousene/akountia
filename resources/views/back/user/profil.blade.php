@extends($layout)
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Paramètres du compte</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('user.profil') }}">Paramètres du compte</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {{-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Compte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bx bx-lock-alt me-1"></i> Sécurité</a>
                    </li>
                </ul> --}}
                <div class="card mb-4">

                    <h5 class="card-header">Détails du profil</h5>
                    <!-- Compte -->
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" action="{{ route('user.profil') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $user->photo ? '/uploads/photos/' . $user->photo : '/uploads/photos/default.png' }}"
                                    alt="avatar-utilisateur" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Télécharger une nouvelle photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" name="photo"
                                            hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Réinitialiser</span>
                                    </button>

                                    <p class="text-muted mb-0">Formats JPG, GIF ou PNG autorisés. Taille max de 800K</p>
                                </div>
                            </div>


                            <div class="row">
                                @can('user.firstname.profil')
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">Prénom</label>
                                        <input class="form-control" type="text" id="firstName" name="firstName"
                                            value="{{ old('firstName', $user->first_name) }}" autofocus />
                                        @error('first_name')
                                            <span class="helper-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endcan
                                @can('user.lastname.profil')
                                    <div class="mb-3 col-md-6">
                                        <label for="lastName" class="form-label">Nom</label>
                                        <input class="form-control" type="text" name="lastName" id="lastName"
                                            value="{{ old('lastName', $user->name) }}" />
                                        @error('name')
                                            <span class="helper-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endcan
                                @can('user.email.profil')
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="text" id="email" name="email"
                                            value="{{ old('email', $user->email) }}" placeholder="john.doe@example.com" />
                                        @error('email')
                                            <span class="helper-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endcan
                                @can('user.login.profil')
                                    <div class="mb-3 col-md-6">
                                        <label for="login" class="form-label">Identifiant</label>
                                        <input class="form-control" type="text" id="login" name="login"
                                            value="{{ $user->login }}" disabled />
                                        @error('login')
                                            <span class="helper-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endcan
                                @can('user.password.profil')
                                    <div class="mb-3 col-md-6">
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <input class="form-control" type="password" id="password" name="password"
                                            placeholder="********" />
                                        @error('password')
                                            <span class="helper-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endcan
                                @can('user.password_confirmation.edit')

                                    <div class="mb-3 col-md-6">
                                        <label for="password_confirmation" class="form-label">Confirmation du mot de
                                            passe</label>
                                        <input class="form-control" type="password" id="password_confirmation"
                                            name="password_confirmation" placeholder="********" />
                                        @error('password_confirmation')
                                            <span class="helper-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endcan
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2 float-start">
                                <button type="reset" class="btn btn-label-secondary">Annuler</button>
                            </div>
                            <div class="mt-2 float-end">
                                <button type="submit" class="btn btn-primary me-2">Enregistrer les modifications</button>
                            </div>
                        </form>
                    </div>

                    <!-- /Compte -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Contenu -->


@stop
@section('js')
    <!-- Page JS -->
    {{-- <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="/assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="/assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script> --}}
    <!-- Page JS ---->

    <script src="/assets/vendors/duallistbox/jquery.bootstrap-duallistbox.js"></script>
    <style>

    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let uploadInput = document.querySelector("#upload");
            let avatarImage = document.querySelector("#uploadedAvatar");
            let resetButton = document.querySelector(".account-image-reset");

            let defaultAvatarSrc = avatarImage.src;

            uploadInput.onchange = function() {
                if (uploadInput.files && uploadInput.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        avatarImage.src = e.target.result;
                    };
                    reader.readAsDataURL(uploadInput.files[0]);
                }
            };

            resetButton.onclick = function() {
                uploadInput.value = "";
                avatarImage.src = defaultAvatarSrc;
            };
        });
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="fonctionnalites[]"]').bootstrapDualListbox();
            $('select[name="permissions[]"]').bootstrapDualListbox();
        });
    </script>
@stop
