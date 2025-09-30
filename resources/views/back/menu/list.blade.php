@extends($layout)
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Gestion des menus </h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('permission.index') }}">Liste des Menus</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Role cards -->
        <div class="row g-4 justify-content-end">
            <div class="col-md-3 text-end">
                <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                    class="btn btn-primary mb-3 text-nowrap add-new-role">
                    Ajouter Nouveau Menu
                </button>
            </div>
        </div>
        <!--/ Role cards -->
        <!-- Add Menu Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="role-title">Ajouter nouveau menu</h3>
                            <p>remplisser le formulaire</p>
                        </div>
                        <!-- Add role form -->
                        <form class="card-body" method="POST" action="{{ route('menu_create') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="titre">Titre du menu</label>
                                    <input type="text" name="titre" id="titre" class="form-control"
                                        placeholder="Prénom" value="{{ old('titre') }}" />
                                    @error('titre')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="page">Page</label>
                                    <select name="page" id="page" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option class='option' value='' selected></option>
                                        @foreach ($routes as $route)
                                            <option class='option' value='{{ $route->getName() }}'>
                                                {{ $route->getName() . ' (' . $route->uri() . ') ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('page')
                                        <span class="helper-text materialize-red-text">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="parent_menu">Menu Parent</label>
                                    <select name="parent_menu" id="parent_menu" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option class='option' value='' selected></option>
                                        @foreach ($menus as $row)
                                            <option class='option' {{ $row->id == old('parent_menu') ? 'selected' : '' }}
                                                value='{{ $row->id }}'> {{ $row->titre }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_menu')
                                        <span class="helper-text materialize-red-text">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="icon">Icône</label>
                                    <select name="icon" id="icon" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option value="">Sélectionner une icône</option>
                                        @foreach ($icons as $iconKey => $iconLabel)
                                            <option value="{{ $iconKey }}"
                                                {{ $iconKey == old('icon') ? 'selected' : '' }}>{{ $iconLabel }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('icon')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="ordre">Ordre</label>
                                    <input type="text" name="ordre" id="ordre" class="form-control"
                                        placeholder="Ordre" value="{{ old('ordre') }}" />
                                    @error('ordre')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="ressource">Ressource</label>
                                    <select name="ressource" id="ressource" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option class='option' value='' selected></option>
                                        @foreach ($ressources as $row)
                                            <option class='option' {{ $row->id == old('ressource') ? 'selected' : '' }}
                                                value='{{ $row->id }}'> {{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('ressource')
                                        <span class="helper-text materialize-red-text">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="desc">Description</label>
                                    <input type="text" name="desc" id="desc" class="form-control"
                                        placeholder="Description" value="{{ old('desc') }}" />
                                    @error('desc')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="statut">Visible</label>
                                    <select name="statut" id="statut" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option value="1"> Oui </option>
                                        <option value="0"> Non </option>
                                    </select>
                                    @error('statut')
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
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Retour
                                </button>
                            </div>
                        </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Menu Modal -->

        <!-- Edit Menu Modal -->
        <div class="modal fade" id="editMenuModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="role-title">Modifier le menu</h3>
                            <p>Modifiez les informations du menu</p>
                        </div>
                        <!-- Edit role form -->
                        <form class="card-body" method="POST" id="editMenuForm">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_titre">Titre du menu</label>
                                    <input type="text" name="titre" id="edit_titre" class="form-control"
                                        placeholder="Titre du menu" />
                                    @error('titre')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_page">Page</label>
                                    <select name="page" id="edit_page" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option class='option' value='' selected></option>
                                        @foreach ($routes as $route)
                                            <option class='option' value='{{ $route->getName() }}'>
                                                {{ $route->getName() . ' (' . $route->uri() . ') ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('page')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_parent_menu">Menu Parent</label>
                                    <select name="parent_menu" id="edit_parent_menu" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option class='option' value='' selected></option>
                                        @foreach ($menus as $row)
                                            <option class='option' value='{{ $row->id }}'> {{ $row->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_menu')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_icon">Icône</label>
                                    <select name="icon" id="edit_icon" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option value="">Sélectionner une icône</option>
                                        @foreach ($icons as $iconKey => $iconLabel)
                                            <option value="{{ $iconKey }}">{{ $iconLabel }}</option>
                                        @endforeach
                                    </select>
                                    @error('icon')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_ordre">Ordre</label>
                                    <input type="text" name="ordre" id="edit_ordre" class="form-control"
                                        placeholder="Ordre" />
                                    @error('ordre')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_ressource">Ressource</label>
                                    <select name="ressource" id="edit_ressource" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option class='option' value='' selected></option>
                                        @foreach ($ressources as $row)
                                            <option class='option' value='{{ $row->id }}'> {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ressource')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_desc">Description</label>
                                    <input type="text" name="desc" id="edit_desc" class="form-control"
                                        placeholder="Description" />
                                    @error('desc')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_statut">Visible</label>
                                    <select name="statut" id="edit_statut" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option value="1"> Oui </option>
                                        <option value="0"> Non </option>
                                    </select>
                                    @error('statut')
                                        <span class="helper-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr class="my-4 mx-n4" />
                            <div class="pt-4 float-end">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Mettre à jour</button>
                            </div>
                            <div class="pt-4 float-start">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Annuler
                                </button>
                            </div>
                        </form>
                        <!--/ Edit role form -->
                    </div>
                </div>
            </div>
        </div>
        <!--/ Edit Menu Modal -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <h5 class="card-header">Glisser pour ajuster les menus </h5>
                    <div class="card-body">
                        <div class="list-group col nested-sortable">
                            @foreach ($topLevelItems as $topLevelItem)
                                <div id="list-group-item" data-id="{{ $topLevelItem->id }}"
                                    class="list-group-item nested-1 ">
                                    <i
                                        class="tf-icons fa-solid fa-{{ $topLevelItem->icon }}"></i>{{ $topLevelItem->titre }}
                                    <button type="button" class="btn btn-sm btn-icon item-edit" data-bs-toggle="modal"
                                        data-bs-target="#editMenuModal" data-menu-id="{{ $topLevelItem->id }}"
                                        data-menu-data='@json($topLevelItem)'><i class="bx bxs-edit"></i></button>
                                    <div class="list-group nested-sortable">
                                        @if (isset($nestedItems[$topLevelItem->id]))
                                            @foreach ($nestedItems[$topLevelItem->id] as $nestedItem)
                                                <div data-id="{{ $nestedItem->id }}" id="list-group-item"
                                                    class="list-group-item nested-1 col-md-6">
                                                    <i
                                                        class="tf-icons fa-solid fa-{{ $nestedItem->icon }}"></i>{{ $nestedItem->titre }}
                                                    <button type="button" class="btn btn-sm btn-icon item-edit"
                                                        data-bs-toggle="modal" data-bs-target="#editMenuModal"
                                                        data-menu-id="{{ $nestedItem->id }}"
                                                        data-menu-data='@json($nestedItem)'><i
                                                            class="bx bxs-edit"></i></button>

                                                    <div class="list-group nested-sortable">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
@section('js')
    <script src="/assets/vendor/libs/sortablejs/sortable.js"></script>
    <style>
        /* Styles améliorés pour Select2 et le modal */
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            line-height: 38px;
            padding: 0 12px;
            border: 1px solid #d9dee3;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        /* Style pour les icônes dans Select2 */
        .select2-results__option i,
        .select2-selection__rendered i {
            min-width: 20px;
            text-align: center;
            color: #666;
            margin-right: 8px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] i {
            color: #fff;
        }

        /* Styles pour le drag & drop */
        .sortable-ghost {
            opacity: 0.4;
            background-color: #f0f0f0;
        }

        .sortable-chosen {
            background-color: #e8f4fd;
        }

        .sortable-drag {
            background-color: #fff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* Fix pour les boutons dans les items draggables */
        .list-group-item .item-edit {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        /* Validation feedback */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        /* Loading state */
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
    <!-- Script JavaScript corrigé pour le modal d'édition -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation des Select2
            initializeSelect2();

            // Gestion du modal d'édition
            const editMenuModal = document.getElementById('editMenuModal');

            if (editMenuModal) {
                editMenuModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    if (!button) return;

                    const menuId = button.getAttribute('data-menu-id');
                    const menuDataStr = button.getAttribute('data-menu-data');

                    if (!menuId || !menuDataStr) {
                        console.error('Données manquantes pour l\'édition');
                        return;
                    }

                    let menuData;
                    try {
                        menuData = JSON.parse(menuDataStr);
                    } catch (e) {
                        console.error('Erreur parsing JSON:', e);
                        return;
                    }

                    // Mettre à jour l'action du formulaire
                    const form = document.getElementById('editMenuForm');
                    if (form) {
                        form.action = '/menu/update/' + menuId;
                    }

                    // Remplir les champs texte
                    setFieldValue('edit_titre', menuData.titre);
                    setFieldValue('edit_ordre', menuData.ordre);
                    setFieldValue('edit_desc', menuData.desc);

                    // Détruire les instances Select2 existantes
                    destroySelect2();

                    // Définir les valeurs des selects
                    setSelectValue('edit_page', menuData.page);
                    setSelectValue('edit_parent_menu', menuData.parent_menu);
                    setSelectValue('edit_icon', menuData.icon);
                    setSelectValue('edit_ressource', menuData.ressource);
                    setSelectValue('edit_statut', menuData.statut !== undefined ? menuData.statut : '1');

                    // Réinitialiser Select2 après un court délai
                    setTimeout(function() {
                        initializeEditSelect2();

                        // Forcer la mise à jour des valeurs Select2
                        $('#edit_page').val(menuData.page || '').trigger('change.select2');
                        $('#edit_parent_menu').val(menuData.parent_menu || '').trigger(
                            'change.select2');
                        $('#edit_icon').val(menuData.icon || '').trigger('change.select2');
                        $('#edit_ressource').val(menuData.ressource || '').trigger(
                            'change.select2');
                        $('#edit_statut').val(menuData.statut !== undefined ? menuData.statut : '1')
                            .trigger('change.select2');
                    }, 100);
                });

                // Nettoyer les Select2 quand le modal se ferme
                editMenuModal.addEventListener('hidden.bs.modal', function() {
                    destroySelect2();
                });
            }

            // Gestion de la soumission du formulaire
            const editForm = document.getElementById('editMenuForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const actionUrl = this.action;

                    // Désactiver le bouton submit pendant l'envoi
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Mise à jour en cours...';
                    }

                    fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erreur réseau: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Fermer le modal
                                const modalInstance = bootstrap.Modal.getInstance(editMenuModal);
                                if (modalInstance) {
                                    modalInstance.hide();
                                }

                                // Afficher un message de succès
                                showNotification('Menu mis à jour avec succès!', 'success');

                                // Recharger la page après un court délai
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                // Afficher les erreurs
                                handleFormErrors(data.errors || {
                                    message: 'Erreur lors de la mise à jour'
                                });

                                // Réactiver le bouton
                                if (submitBtn) {
                                    submitBtn.disabled = false;
                                    submitBtn.textContent = 'Mettre à jour';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            showNotification('Une erreur est survenue: ' + error.message, 'error');

                            // Réactiver le bouton
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Mettre à jour';
                            }
                        });
                });
            }
        });

        // Fonctions utilitaires

        function setFieldValue(fieldId, value) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.value = value || '';
            }
        }

        function setSelectValue(selectId, value) {
            const select = document.getElementById(selectId);
            if (select) {
                select.value = value || '';

                // Vérifier si l'option existe
                const optionExists = Array.from(select.options).some(option => option.value == value);
                if (!optionExists && value) {
                    console.warn(`Option ${value} n'existe pas pour ${selectId}`);
                }
            }
        }

        function destroySelect2() {
            // Détruire toutes les instances Select2 dans le modal d'édition
            $('#editMenuModal .select2').each(function() {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
            });
        }

        function initializeSelect2() {
            // Configuration pour les icônes avec preview
            function formatIcon(option) {
                if (!option.id) return option.text;

                const iconClass = 'fa-solid fa-' + option.id;
                return $('<span><i class="' + iconClass + '" style="margin-right: 8px; width: 16px;"></i>' + option.text +
                    '</span>');
            }

            // Initialiser Select2 pour le modal d'ajout
            $('#addRoleModal select.select2').not('#icon').select2({
                dropdownParent: $('#addRoleModal'),
                width: '100%',
                allowClear: true,
                placeholder: 'Sélectionner...'
            });

            $('#icon').select2({
                dropdownParent: $('#addRoleModal'),
                width: '100%',
                templateResult: formatIcon,
                templateSelection: formatIcon,
                escapeMarkup: function(markup) {
                    return markup;
                },
                allowClear: true,
                placeholder: 'Sélectionner une icône'
            });
        }

        function initializeEditSelect2() {
            // Configuration pour les icônes avec preview
            function formatIcon(option) {
                if (!option.id) return option.text;

                const iconClass = 'fa-solid fa-' + option.id;
                return $('<span><i class="' + iconClass + '" style="margin-right: 8px; width: 16px;"></i>' + option.text +
                    '</span>');
            }

            // Initialiser Select2 pour le modal d'édition
            $('#editMenuModal select.select2').not('#edit_icon').select2({
                dropdownParent: $('#editMenuModal'),
                width: '100%',
                allowClear: true,
                placeholder: 'Sélectionner...'
            });

            $('#edit_icon').select2({
                dropdownParent: $('#editMenuModal'),
                width: '100%',
                templateResult: formatIcon,
                templateSelection: formatIcon,
                escapeMarkup: function(markup) {
                    return markup;
                },
                allowClear: true,
                placeholder: 'Sélectionner une icône'
            });
        }

        function handleFormErrors(errors) {
            // Nettoyer les erreurs précédentes
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.remove();
            });

            // Afficher les nouvelles erreurs
            if (typeof errors === 'object') {
                Object.keys(errors).forEach(field => {
                    const input = document.querySelector(`#editMenuForm [name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');

                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = Array.isArray(errors[field]) ? errors[field][0] : errors[field];

                        input.parentNode.appendChild(feedback);
                    }
                });
            } else {
                showNotification(errors, 'error');
            }
        }

        function showNotification(message, type = 'info') {
            // Si vous utilisez un système de notification (toastr, sweetalert, etc.)
            if (typeof toastr !== 'undefined') {
                toastr[type](message);
            } else {
                // Fallback avec alert
                alert(message);
            }
        }

        // Configuration Sortable
        document.querySelectorAll('.nested-sortable').forEach(function(nestedSortable) {
            if (typeof Sortable !== 'undefined') {
                new Sortable(nestedSortable, {
                    group: 'nested',
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    handle: '.list-group-item',
                    filter: '.btn',
                    preventOnFilter: false,
                    onEnd: function(evt) {
                        // Logique de mise à jour après le drag & drop
                        updateMenuOrder();
                    }
                });
            }
        });

        function updateMenuOrder() {
            const menuItems = [];

            document.querySelectorAll('#list-group-item').forEach(function(item, index) {
                const id = item.getAttribute('data-id');
                const parentItem = item.parentElement.closest('#list-group-item');
                const parentId = parentItem ? parentItem.getAttribute('data-id') : null;

                menuItems.push({
                    id: id,
                    parent_id: parentId,
                    ordre: index + 1
                });
            });

            // Débounce pour éviter les requêtes multiples
            clearTimeout(window.updateTimeout);
            window.updateTimeout = setTimeout(function() {
                fetch("{{ route('update_menus_drag') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(menuItems)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Ordre mis à jour', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur mise à jour ordre:', error);
                    });
            }, 500);
        }
    </script>

@stop
