@extends($layout)

@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
@stop
@section('content')

    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Gestion des utilisateurs</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('user.index') }}">Liste des utilisateurs</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Multi Column with Form Separator -->
        <div class="card mb-4">
            <h5 class="card-header"></h5>
            <form class="card-body" method="POST" action="{{ route('user.update', ['user' => $user->id]) }}">
                @csrf
                @method('Put')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Prénom"
                            value="{{ old('first_name', $user->first_name) }}" />
                        @error('first_name')
                            <span class="helper-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="name">Nom</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nom"
                            value="{{ old('name', $user->name) }}" />
                        @error('name')
                            <span class="helper-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @can('user.email.update')
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email"
                                value="{{ old('email', $user->email) }}" />
                            @error('email')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan
                    <div class="col-md-6">
                        <label class="form-label" for="login">Login</label>
                        <input type="text" name="login" id="login" class="form-control" placeholder="Login"
                            value="{{ old('login', $user->login) }}" />
                        @error('login')
                            <span class="helper-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-password-toggle">
                            <label class="form-label" for="password">Mot de passe</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" id="multicol-password" class="form-control"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-password2" />
                                <span class="input-group-text cursor-pointer" id="multicol-password2"><i
                                        class="bx bx-hide"></i></span>
                            </div>
                            @error('password')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-password-toggle">
                            <label class="form-label" for="password_confirmation">Confirmation mot de passe</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-confirm-password2" />
                                <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"><i
                                        class="bx bx-hide"></i></span>
                            </div>
                            @error('password_confirmation')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="role">Role</label>
                        <select name="role" id="role" class="select2 form-select form-select"
                            data-allow-clear="true">
                            @foreach ($roles as $role)
                                <option class="option" {{ $role->id == old('role', $user->role) ? 'selected' : '' }}
                                    value="{{ $role->id }}">{{ $role->label }}</option>
                            @endforeach
                        </select>
                        @error('role')
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
                    <a href="{{ route('user.index') }}" class="btn btn-label-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
@stop
@section('js')
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/js/forms-selects.js"></script>

@stop
