@extends($layout)

@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

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
        <form class="card-body" method="POST" action="{{ route('user.store') }}" id="formValidationUser">
            @csrf
            <div class="row g-3">
                @can('user.first_name.create')
                <div class="col-md-6">
                    <label class="form-label" for="first_name">Prénom</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Prénom"
                        value="{{ old('first_name') }}" />
                    @error('first_name')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @endcan
                @can('user.last_name.create')
                <div class="col-md-6">
                    <label class="form-label" for="name">Nom</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nom"
                        value="{{ old('name') }}" />
                    @error('name')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @endcan
                @can('user.email.create')
                <div class="col-md-6">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email"
                        value="{{ old('email') }}" />
                    @error('email')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @endcan
                @can('user.login.create')
                <div class="col-md-6">
                    <label class="form-label" for="login">Login</label>
                    <input type="text" name="login" id="login" class="form-control" placeholder="Login"
                        value="{{ old('login') }}" />
                    @error('login')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @endcan
                @can('user.password.create')
                <div class="col-md-6">
                    <div class="form-password-toggle">
                        <label class="form-label" for="password">Mot de passe</label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" id="password" class="form-control"
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
                @endcan
                @can('user.password_confirmation.create')
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
                @endcan
                @can('user.role.create')
                <div class="col-md-6">
                    <label class="form-label" for="role">Role</label>
                    <select name="role" id="role" class="select2 form-select" data-allow-clear="true">
                        <option value="?">Selectionner un rôle</option>
                        @foreach ($roles as $role)
                        <option class="option" {{ $role->id == old('role') ? 'selected' : '' }} value="{{ $role->id
                            }}">{{ $role->label }}</option> @endforeach
                    </select>
                    @error('role')
                    <span class="helper-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @endcan
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
<script src="/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
<script src="/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
<script src="/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function (e) {
        (function () {
            const formValidationUser = document.getElementById('formValidationUser'),
                formValidationRole = jQuery(formValidationUser.querySelector('[name="role"]'));

            const fv = FormValidation.formValidation(formValidationUser, {
                fields: {
                    first_name: {
                        validators: {
                            notEmpty: {
                                message: 'Veuillez entrer votre prénom.'
                            },
                            stringLength: {
                                min: 2,
                                max: 30,
                                message: 'Le prénom doit comporter plus de 2 caractères et moins de 30 caractères.'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9 ]+$/,
                                message: 'Le prénom ne peut contenir que des caractères alphabétiques, des chiffres et des espaces.'
                            }
                        }
                    },
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Veuillez entrer votre nom.'
                            },
                            stringLength: {
                                min: 2,
                                max: 30,
                                message: 'Le nom doit comporter plus de 2 caractères et moins de 30 caractères.'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9 ]+$/,
                                message: 'Le nom ne peut contenir que des caractères alphabétiques, des chiffres et des espaces.'
                            }
                        }
                    },
                    login: {
                        validators: {
                            notEmpty: {
                                message: 'Veuillez entrer votre login.'
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: 'Le login doit comporter plus de 6 caractères et moins de 30 caractères.'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Veuillez entrer votre mot de passe.'
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: 'Veuillez confirmer votre mot de passe.'
                            },
                            identical: {
                                compare: function () {
                                    return formValidationUser.querySelector('[name="password"]')
                                        .value;
                                },
                                message: 'Le mot de passe et sa confirmation ne sont pas identiques.'
                            }
                        }
                    },
                    role: {
                        validators: {
                            notEmpty: {
                                message: 'Veuillez selectionner un rôle.'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        // Use this for enabling/changing valid/invalid class
                        // eleInvalidClass: '',
                        eleValidClass: '',
                        rowSelector: function (field, ele) {
                            // field is the field name & ele is the field element
                            switch (field) {
                                case 'first_name':
                                case 'name':
                                case 'password':
                                case 'password_confirmation':
                                case 'role':
                                default:
                                    return '.row';
                            }
                        }
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // Submit the form when all fields are valid
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    instance.on('plugins.message.placed', function (e) {
                        //* Move the error message out of the `input-group` element
                        if (e.element.parentElement.classList.contains('input-group')) {
                            // `e.field`: The field name
                            // `e.messageElement`: The message element
                            // `e.element`: The field element
                            e.element.parentElement.insertAdjacentElement('afterend', e
                                .messageElement);
                        }
                        //* Move the error message out of the `row` element for custom-options
                        if (e.element.parentElement.parentElement.classList.contains(
                            'custom-option')) {
                            e.element.closest('.row').insertAdjacentElement('afterend',
                                e.messageElement);
                        }
                    });
                }
            });

            // Select2 (role)
            if (formValidationRole.length) {

                formValidationRole.wrap('<div class="position-relative"></div>');
                formValidationRole
                    .select2({
                        placeholder: 'Selectionner un rôle.',
                        dropdownParent: formValidationRole.parent()
                    })
                    .on('change.select2', function () {
                        // Revalidate the color field when an option is chosen
                        console.log(formValidationRole.length)
                        fv.revalidateField('role');
                    });
            }

        })();
    });
</script>
@stop
