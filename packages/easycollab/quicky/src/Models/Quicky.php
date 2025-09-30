<?php

namespace EasyCollab\Quicky\Models;

use App\Models\Permission;
use App\Models\Quickyproject;
use EasyCollab\Quicky\Models\FormType;
use Illuminate\Database\Eloquent\Model;

class Quicky extends Model
{
    protected $table = 'users';

    /**
     * Normalise les données $_POST pour éviter les erreurs
     */
    private static function normalizePostData()
    {
        // Arrays principaux
        $arrays = ['Identifiant', 'Label', 'formElement', 'del', 'visible', 'inGrid', 'size'];
        foreach ($arrays as $key) {
            if (!isset($_POST[$key]) || !is_array($_POST[$key])) {
                $_POST[$key] = [];
            }
        }

        // Arrays imbriqués pour les options
        $nestedArrays = ['Select_cle', 'Select_valeur', 'Radio_cle', 'Radio_valeur', 'Checkbox_cle', 'Checkbox_valeur', 'skmodel', 'skkey', 'skvalue'];
        foreach ($nestedArrays as $key) {
            if (!isset($_POST[$key]) || !is_array($_POST[$key])) {
                $_POST[$key] = [];
            }
        }

        // Valeurs simples
        if (!isset($_POST['projet'])) {
            $_POST['projet'] = '';
        }
        if (!isset($_POST['projetid'])) {
            $_POST['projetid'] = '';
        }
        if (!isset($_POST['serverSide'])) {
            $_POST['serverSide'] = 0;
        }
        if (!isset($_POST['colNumber'])) {
            $_POST['colNumber'] = 6;
        }
    }

    public static function genListView()
    {
        // S'assurer que les données existent
        if (!isset($_POST['Identifiant']) || !is_array($_POST['Identifiant'])) {
            $_POST['Identifiant'] = [];
        }

        $th = $td = $serverSide = "";
        $serverSideColumns = ["{data: '',}"];
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0 && $_POST['inGrid'][$key] == 1 && $_POST['formElement'][$key] != "primary_key" && $_POST['formElement'][$key] != "hidden") {

                $label = $_POST['Label'][$key];
                if ($_POST["serverSide"] == 1) {
                    $serverSideColumns[] = "{data:'$value', name:'$value'}";
                }
                $th .= "
                                            <th> $label </th>";
            }
        }

        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0 && $_POST['inGrid'][$key] == 1 && $_POST['formElement'][$key] != "primary_key" && $_POST['formElement'][$key] != "hidden") {
                $id = $_POST['Identifiant'][$key];
                $type = $_POST['formElement'][$key];
                switch ($type) {
                    case "secondary_key":
                        $skvalue = isset($_POST['skvalue'][$key]) ? $_POST['skvalue'][$key] : 'name';
                        $recordVar = strtolower(isset($_POST['skmodel'][$key]) ? $_POST['skmodel'][$key] : 'Model') . "Detail";
                        $td .= "
                                            <td> {{ \$record->$recordVar->$skvalue }} </td>";
                        break;
                    case "file":
                        $td .= "
                                            <td>
                                                @if(\$record->$id)
                                                    <a href=\"{{ Storage::url(\$record->$id) }}\" target=\"_blank\" class=\"btn btn-sm btn-outline-primary\">
                                                        <i class=\"bx bx-file\"></i> Voir
                                                    </a>
                                                @else
                                                    <span class=\"text-muted\">Aucun fichier</span>
                                                @endif
                                            </td>";
                        break;
                    case "email":
                        $td .= "
                                            <td>
                                                @if(\$record->$id)
                                                    <a href=\"mailto:{{ \$record->$id }}\">{{ \$record->$id }}</a>
                                                @endif
                                            </td>";
                        break;
                    case "url":
                        $td .= "
                                            <td>
                                                @if(\$record->$id)
                                                    <a href=\"{{ \$record->$id }}\" target=\"_blank\" class=\"text-decoration-none\">
                                                        {{ Str::limit(\$record->$id, 30) }}
                                                        <i class=\"bx bx-link-external ms-1\"></i>
                                                    </a>
                                                @endif
                                            </td>";
                        break;
                    case "colorpicker":
                        $td .= "
                                            <td>
                                                @if(\$record->$id)
                                                    <div class=\"d-flex align-items-center\">
                                                        <div style=\"width: 20px; height: 20px; background-color: {{ \$record->$id }}; border: 1px solid #ddd; border-radius: 3px; margin-right: 8px;\"></div>
                                                        {{ \$record->$id }}
                                                    </div>
                                                @endif
                                            </td>";
                        break;
                    case "datepicker":
                        $td .= "
                                            <td>
                                                {{ \$record->$id ? \Carbon\Carbon::parse(\$record->$id)->format('d/m/Y') : '' }}
                                            </td>";
                        break;
                    case "timepicker":
                        $td .= "
                        <td>
                                {{ \$record->$id ? \Carbon\Carbon::parse(\$record->$id)->format('H:i') : '' }}
                        </td>";
                        break;
                    case "select_multiple":
                    case "select_multiple_basic":
                    case "checkbox":
                        $td .= "
                                            <td>
                                                @if(\$record->$id && is_array(json_decode(\$record->$id, true)))
                                                    <span class=\"badge bg-label-info\">{{ count(json_decode(\$record->$id, true)) }} élément(s)</span>
                                                @endif
                                            </td>";
                        break;
                    case "ckeditor":
                    case "textarea":
                        $td .= "
                                            <td>
                                                {{ Str::limit(strip_tags(\$record->$id), 50) }}
                                            </td>";
                        break;
                    case "password":
                        $td .= "
                                            <td>
                                                <span class=\"text-muted\">••••••••</span>
                                            </td>";
                        break;
                    case "hidden":
                        // Les champs cachés ne s'affichent pas dans la liste
                        break;
                    default:
                        $td .= "
                                            <td> {{ \$record->$id }} </td>";
                        break;
                }
            }
        }

        if ($_POST["serverSide"] == 1) {
            $project = strtolower($_POST['projet']);
            $serverSideColumns[] = "{data: 'action', name: 'action', orderable: false, searchable: false}";
            $columns = implode(", ", $serverSideColumns);
            $keys = array_keys($serverSideColumns);
            $columns_to_export = array_slice($keys, 1, -1);
            $columns_to_export = '[' . implode(', ', $columns_to_export) . ']';

            $serverSide = <<<SERVERSIDE
            $(document).ready(function() {
                'use strict';
                var dt_filter_table = $('.dt-column-search');
                var dt_filter = dt_filter_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('$project.data') }}",
                    columns: [$columns],
                    columnDefs: [{
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        responsivePriority: 2,
                        searchable: false,
                        targets: 0,
                        render: function(data, type, full, meta) {
                            return '';
                        }
                    }],
                    language: {
                        url: '/assets/vendors/data-tables/i18n/fr_fr.json'
                    },
                    dom: '<"card-header"<"head-label text-center"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 5,
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
                                        columns: $columns_to_export
                                    }
                                },
                                {
                                    extend: 'csv',
                                    text: '<i class="bx bx-file me-1" ></i>Csv',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: $columns_to_export
                                    }
                                },
                                {
                                    extend: 'excel',
                                    text: '<i class="bx bx-file me-1" ></i>Excel',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: $columns_to_export
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: $columns_to_export
                                    }
                                },
                                {
                                    extend: 'copy',
                                    text: '<i class="bx bx-copy me-1" ></i>Copier',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: $columns_to_export
                                    }
                                }
                            ]
                        },
                        {
                            text: '<i class="bx bx-plus me-1"></i> <span class="d-none d-lg-inline-block">Ajouter</span>',
                            className: 'create-new btn btn-primary',
                            action: function (e, dt, node, config)
                            {
                                window.location.href = '{{route('$project.create')}}';
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
                                    return col.title !== ''
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
                // Clone the original header row
                $('.dt-column-search thead tr').clone(true).addClass('d-none d-sm-table-row').appendTo('.dt-column-search thead');
                // Remove the first and the last th from the cloned row
                $('.dt-column-search thead tr:eq(1) th:first').remove();
                $('.dt-column-search thead tr:eq(1) th:last').html("");

                $('.dt-column-search thead tr:eq(1) th:not(:last)').each(function (i) {
                    $(this).html('<div class="input-group input-group-merge"><span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span><input type="text" class="form-control" placeholder="..." aria-label="..." aria-describedby="basic-addon-search31"></div>');
                    $('input', this).on('keyup change', function () {
                        if (dt_filter.column(i + 1).search() !== this.value) {
                            dt_filter.column(i + 1).search(this.value).draw();
                        }
                    });
                });
                $('.head-label').html('<h5 class="card-title mb-0">DataTable with Buttons</h5>');
            });
        SERVERSIDE;
        }


        $contenu = file_get_contents(base_path() . "/packages/easycollab/quicky/src/Templates/List.php");
        $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
        $contenu = str_replace('{th}', $th, $contenu);
        $contenu = str_replace('{td}', $td, $contenu);

        $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
        $contenu = str_replace('{th}', $th, $contenu);
        $contenu = str_replace('{td}', $td, $contenu);
        $contenu = str_replace('{serverSide}', $serverSide, $contenu);
        $path = base_path() . '/resources/views/back/' . strtolower($_POST['projet']);
        if (!is_dir($path)) {
            @mkdir($path);
        }
        $file = fopen($path . '/index.blade.php', 'w+');
        fwrite($file, $contenu);
        fclose($file);
    }

    public static function genActions()
    {
        // Normaliser les données POST
        self::normalizePostData();
        if ($_POST["serverSide"] == 1) {
            $contenu = file_get_contents(base_path() . "/packages/easycollab/quicky/src/Templates/Actions.php");
            $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
            $path = base_path() . '/resources/views/back/' . strtolower($_POST['projet']);
            if (!is_dir($path)) {
                @mkdir($path);
            }
            $file = fopen($path . '/actions.blade.php', 'w+');
            fwrite($file, $contenu);
            fclose($file);
        }
    }

    public static function genCreateView($isUpdate = false): void
    {
        // Normaliser les données POST
        self::normalizePostData();
        $project = strtolower($_POST['projet']);
        $viewPath = "views/back/$project/create.blade.php";
        $templatePath = base_path() . "/packages/easycollab/quicky/src/Templates/Create.php";
        $formTypes = self::generateFormTypes();
        if ($isUpdate) {
            $formTypes .= "\n \n <!--updates_fields-->";
            $contenu = file_get_contents(resource_path($viewPath));
            $contenu = str_replace(['<!--updates_fields-->'], [$formTypes], $contenu);
        } else {
            $contenu = file_get_contents($templatePath);
            $contenu = str_replace(['{projetId}', '{formTypes}'], [$project, $formTypes], $contenu);
        }
        self::fileWrite(resource_path($viewPath), $contenu);
    }

    public static function genUpdateView($isUpdate = false): void
    {
        // Normaliser les données POST
        self::normalizePostData();
        $project = strtolower($_POST['projet']);
        $viewPath = "views/back/$project/edit.blade.php";
        $templatePath = base_path() . "/packages/easycollab/quicky/src/Templates/Update.php";
        $formTypes = self::generateFormTypes(true);
        if ($isUpdate) {
            $formTypes .= "\n \n <!--updates_fields-->";
            $contenu = file_get_contents(resource_path($viewPath));
            $contenu = str_replace(['<!--updates_fields-->'], [$formTypes], $contenu);
        } else {
            $contenu = file_get_contents($templatePath);
            $contenu = str_replace(['{projetId}', '{formTypes}'], [$project, $formTypes], $contenu);
        }

        self::fileWrite(resource_path($viewPath), $contenu);
    }

    private static function generateFormTypes($isUpdate = false): string
    {
        // Normaliser les données POST
        self::normalizePostData();

        $formTypes = "";
        $project = strtolower($_POST['projet']);
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $label = $_POST['Label'][$key];
                $columns = $_POST['colNumber'] ?? 6;
                $type = $_POST['formElement'][$key];
                switch ($type) {
                    case "secondary_key":
                        $skkey = isset($_POST['skkey'][$key]) ? $_POST['skkey'][$key] : 'id';
                        $skvalue = isset($_POST['skvalue'][$key]) ? $_POST['skvalue'][$key] : 'name';
                        $recordVar = strtolower(isset($_POST['skmodel'][$key]) ? $_POST['skmodel'][$key] : 'Model') . "Records";
                        $formTypes .= FormType::generateFormHtml($project, $label, $id, $columns, $type, $isUpdate, $recordVar, $skkey, $skvalue);

                        break;
                    case "select":
                        if (isset($_POST['Select_valeur'][$key])) {
                            $select_radio_value = $_POST['Select_valeur'][$key];
                            $select_radio_key = $_POST['Select_cle'][$key];
                            $formTypes .= FormType::generateFormHtml($project, $label, $id, $columns, $type, $isUpdate, null, null, null, $select_radio_key, $select_radio_value);
                        }
                        break;
                    case "radio":
                        if (isset($_POST['Radio_valeur'][$key])) {
                            $select_radio_value = $_POST['Radio_valeur'][$key];
                            $select_radio_key = $_POST['Radio_cle'][$key];
                            $formTypes .= FormType::generateFormHtml($project, $label, $id, $columns, $type, $isUpdate, null, null, null, $select_radio_key, $select_radio_value);
                        }
                        break;
                    default:
                        $formTypes .= FormType::generateFormHtml($project, $label, $id, $columns, $type, $isUpdate);
                        break;
                }
            }
        }
        return $formTypes;
    }

    private static function fileWrite($filePath, $contents)
    {
        $dir = dirname($filePath);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($filePath, $contents);
    }

    public static function genCreateViewOld()
    {
        // Normaliser les données POST
        self::normalizePostData();

        $formTypes = "";
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $label = $_POST['Label'][$key];
                $columns = $_POST['colNumber'] ?? 6;
                $type = $_POST['formElement'][$key];
                switch ($type) {
                    case "primary_key":
                        break;
                    case "secondary_key":

                        $skkey = isset($_POST['skkey'][$key]) ? $_POST['skkey'][$key] : 'id';
                        $skvalue = isset($_POST['skvalue'][$key]) ? $_POST['skvalue'][$key] : 'name';
                        $recordVar = strtolower(isset($_POST['skmodel'][$key]) ? $_POST['skmodel'][$key] : 'Model') . "Records";

                        $formTypes .= <<<FT
                        <div class="col-md-$columns">
                            <label class="form-label" for="$id">$label</label>
                            <select name="$id" id="$id" class="select2 form-select form-select" data-allow-clear="true">
                                @foreach (\$$recordVar as \$row)
                                <option class="option" {{ \$row->$skkey == old('$id') ? 'selected' : '' }} value="{{ \$row->$skkey }}"> {{ \$row->$skvalue }}</option>
                                @endforeach
                            </select>
                            @error('$id')
                            <span class="helper-text text-danger">{{ \$message }}</span>
                            @enderror
                        </div>
                        FT;
                        break;
                    case "text":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns);
                        break;
                    case "select":

                        $formTypes .= "
                                    <div class=\"col-md-$columns \">
                                    <label for=\"$id\" class=\"form-label\">$label</label>
                                    <select name='$id' id='$id' class=\"select2 form-select form-select\" data-allow-clear=\"true\">
                                    <option value=''></option>
                                ";
                        if (isset($_POST['Select_valeur'][$key])) {
                            foreach ((array)(isset($_POST['Select_valeur'][$key]) ? $_POST['Select_valeur'][$key] : []) as $cle => $valeur) {
                                $option_cle = isset($_POST['Select_cle'][$key][$cle]) ? $_POST['Select_cle'][$key][$cle] : '';
                                $option_val = isset($_POST['Select_valeur'][$key][$cle]) ? $_POST['Select_valeur'][$key][$cle] : '';
                                $formTypes .= "<option value=\"$option_cle\"> $option_val </option> \n";
                            }
                        }
                        $formTypes .= "</select>
                                    @error('$id')
                                        <span class=\"helper-text text-danger\">{{ \$message }}</span>
                                    @enderror
                                </div>
                                    ";
                        break;

                    case "select_multiple":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "select_multiple");
                        break;
                    case "select_basic":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "select_basic");
                        break;
                    case "select_multiple_basic":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "select_multiple_basic");
                        break;
                    case "textarea":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "textarea");
                        break;
                    case "ckeditor":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "ckeditor");
                        break;
                    case "radio":
                        $formTypes .= "
                                    <div class=\"col-md-$columns \">
                                    <small class=\"text-light fw-medium\">$label</small>
                                ";
                        if (isset($_POST['Radio_valeur'][$key])) {
                            foreach ((array)(isset($_POST['Radio_valeur'][$key]) ? $_POST['Radio_valeur'][$key] : []) as $cle => $valeur) {
                                $option_cle = isset($_POST['Radio_cle'][$key][$cle]) ? $_POST['Radio_cle'][$key][$cle] : '';
                                $option_val = isset($_POST['Radio_valeur'][$key][$cle]) ? $_POST['Radio_valeur'][$key][$cle] : '';
                                $formTypes .= <<<RADIO
                                            <div class="form-check">
                                                <input name="$id" class="form-check-input" type="radio" value="$option_cle" id="radio_$cle">
                                                <label class="form-check-label" for="radio_$cle"> $option_val </label>
                                            </div>
                                RADIO;
                            }
                        }
                        $formTypes .= "</p>
                                    @error('$id')
                                        <span class=\"helper-text text-danger\">{{ \$message }}</span>
                                    @enderror
                                </div>
                                    ";
                        break;
                    case "checkbox":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "checkbox");
                        break;
                    case "datepicker":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "datepicker");
                        break;
                    case "timepicker":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "timepicker");
                        break;
                    case "colorpicker":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "colorpicker");
                        break;
                    case "file":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "file");
                        break;
                    case "phone":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, 'phone');
                        break;
                    case "email":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, 'email');
                        break;
                    case "number":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, 'number');
                        break;
                    case "password":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, 'password');
                        break;
                    case "url":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, 'url');
                        break;
                    case "hidden":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, 'hidden');
                        break;
                    default:
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns);
                        break;
                }
            }
        }

        $contenu = file_get_contents(base_path() . "/packages/easycollab/quicky/src/Templates/Create.php");
        $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
        $contenu = str_replace('{formTypes}', $formTypes, $contenu);

        $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
        $contenu = str_replace('{formTypes}', $formTypes, $contenu);
        $path = base_path() . '/resources/views/back/' . strtolower($_POST['projet']);
        if (!is_dir($path)) {
            @mkdir($path);
        }
        $file = fopen($path . '/create.blade.php', 'w+');
        fwrite($file, $contenu);
        fclose($file);
    }


    public static function genUpdateViewOld()
    {
        // Normaliser les données POST
        self::normalizePostData();

        $formTypes = "";

        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $label = $_POST['Label'][$key];
                $columns = $_POST['colNumber'] ?? 6;
                $type = $_POST['formElement'][$key];
                switch ($type) {
                    case "primary_key":
                        break;
                    case "secondary_key":
                        $skkey = isset($_POST['skkey'][$key]) ? $_POST['skkey'][$key] : 'id';
                        $skvalue = isset($_POST['skvalue'][$key]) ? $_POST['skvalue'][$key] : 'name';
                        $recordVar = strtolower(isset($_POST['skmodel'][$key]) ? $_POST['skmodel'][$key] : 'Model') . "Records";

                        $formTypes .= <<<FT
                            <div class="col-md-$columns">
                                <label class="form-label" for="$id">$label</label>
                                <select name="$id" id="$id" class="select2 form-select form-select" data-allow-clear="true">
                                    @foreach (\$$recordVar as \$row)
                                    <option class="option" {{ \$row->$skkey == old('$id', \$record->$id) ? 'selected' : '' }} value="{{ \$row->$skkey }}"> {{ \$row->$skvalue }}</option>
                                    @endforeach
                                </select>
                                @error('$id')
                                <span class="helper-text text-danger">{{ \$message }}</span>
                                @enderror
                            </div>
                         FT;
                        break;
                    case "text":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns);
                        break;
                    case "select":
                        $formTypes .= "
                                    <div class=\"col-md-$columns \">
                                    <label for=\"$id\" class=\"form-label\">$label</label>
                                    <select name='$id' id='$id' class=\"select2 form-select form-select\" data-allow-clear=\"true\">
                                ";
                        if (isset($_POST['Select_valeur'][$key])) {
                            foreach ((array)(isset($_POST['Select_valeur'][$key]) ? $_POST['Select_valeur'][$key] : []) as $cle => $valeur) {
                                $option_cle = isset($_POST['Select_cle'][$key][$cle]) ? $_POST['Select_cle'][$key][$cle] : '';
                                $option_val = isset($_POST['Select_valeur'][$key][$cle]) ? $_POST['Select_valeur'][$key][$cle] : '';
                                $formTypes .= "<option value=\"$option_cle\" {{(\$record->$id == '$option_cle') ? 'selected' : ''}}> $option_val </option> \n";
                            }
                        }
                        $formTypes .= "</select>
                                            @error('$id')
                                                <div class=\"text-danger\">
                                                    {{ \$message }}
                                                </div>
                                            @enderror
                                    </div>";
                        break;

                    case "select_multiple":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "select_multiple");
                        break;
                    case "select_basic":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "select_basic");
                        break;
                    case "select_multiple_basic":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "select_multiple_basic");
                        break;
                    case "textarea":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "textarea");
                        break;
                    case "ckeditor":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "ckeditor");
                        break;

                    case "radio":
                        $formTypes .= "
                                    <div class=\"col-md-$columns \">
                                    <small class=\"text-light fw-medium\">$label</small>
                                ";
                        if (isset($_POST['Radio_valeur'][$key])) {
                            foreach ((array)(isset($_POST['Radio_valeur'][$key]) ? $_POST['Radio_valeur'][$key] : []) as $cle => $valeur) {
                                $option_cle = isset($_POST['Radio_cle'][$key][$cle]) ? $_POST['Radio_cle'][$key][$cle] : '';
                                $option_val = isset($_POST['Radio_valeur'][$key][$cle]) ? $_POST['Radio_valeur'][$key][$cle] : '';
                                $formTypes .= <<<RADIO
                                            <div class="form-check">
                                                <input name="$id" class="form-check-input" {{(\$record->$id == '$option_cle') ? 'checked' : ''}} type="radio" value="$option_cle" id="radio_$cle">
                                                <label class="form-check-label" for="radio_$cle"> $option_val </label>
                                            </div>
                                RADIO;
                            }
                        }
                        $formTypes .= "</p>
                                    @error('$id')
                                        <span class=\"helper-text text-danger\">{{ \$message }}</span>
                                    @enderror
                                </div>
                                    ";
                        break;
                    case "checkbox":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "checkbox");
                        break;
                    case "datepicker":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "datepicker");
                        break;
                    case "timepicker":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "timepicker");
                        break;
                    case "colorpicker":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "colorpicker");
                        break;
                    case "file":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "file");
                        break;
                    case "phone":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, 'phone');
                        break;
                    case "email":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, 'email');
                        break;
                    case "number":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, 'number');
                        break;
                    case "password":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, 'password');
                        break;
                    case "url":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, 'url');
                        break;
                    case "hidden":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, 'hidden');
                        break;
                    default:
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns);
                        break;
                }
            }
        }

        $contenu = file_get_contents(base_path() . "/packages/easycollab/quicky/src/Templates/Update.php");
        $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
        $contenu = str_replace('{formTypes}', $formTypes, $contenu);
        $path = base_path() . '/resources/views/back/' . strtolower($_POST['projet']);
        if (!is_dir($path)) {
            @mkdir($path);
        }
        $file = fopen($path . '/edit.blade.php', 'w+');
        fwrite($file, $contenu);
        fclose($file);
    }

    public static function addRoutes()
    {
        // Normaliser les données POST
        self::normalizePostData();
        $projetId = strtolower($_POST['projet']);
        $controller = ucfirst($_POST['projet']) . "Controller";
        $routes = "Route::resource('$projetId', '$controller')->except(['show']);";
        if ($_POST["serverSide"] == 1) {
            $routes .= "\nRoute::get('$projetId/data', '$controller@data')->name('{$projetId}.data');";
        }
        $contenu = file_get_contents(base_path() . "/routes/web.php");
        $contenu .= "\n\n// $projetId \n" . $routes;
        $routesFile = fopen(base_path() . "/routes/web.php", 'w+');
        fwrite($routesFile, $contenu);
        fclose($routesFile);
    }

    public static function genModelFile()
    {
        // Normaliser les données POST
        self::normalizePostData();
        $contenu = file_get_contents(base_path() . "/packages/easycollab/quicky/src/Templates/Model.php");
        $contenu = str_replace('{CLASS_NAME}', ucfirst(strtolower($_POST['projet'])), $contenu);
        $contenu = str_replace('{TABEL_NAME}', strtolower($_POST['projet']) . 's', $contenu);
        $fkFunctions = "";
        $serverSide = "";
        $relations = [];
        $columns = "";
        $casts = [];
        $project = strtolower($_POST['projet']);
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $type = $_POST['formElement'][$key];

                // Gestion des casts pour les différents types
                switch ($type) {
                    case 'select_multiple':
                    case 'select_multiple_basic':
                    case 'checkbox':
                        $casts[] = "'$id' => 'array'";
                        break;
                    case 'datepicker':
                        $casts[] = "'$id' => 'date'";
                        break;
                    case 'timepicker':
                        $casts[] = "'$id' => 'datetime:H:i'";
                        break;
                    case 'number':
                        $casts[] = "'$id' => 'integer'";
                        break;
                }

                // Ajouter les colonnes DataTables seulement pour les champs visibles dans la grille
                if (isset($_POST['inGrid'][$key]) && $_POST['inGrid'][$key] == 1 && $type != "primary_key" && $type != "hidden") {
                    if ($type == 'secondary_key') {
                        $model = strtolower(isset($_POST['skmodel'][$key]) ? $_POST['skmodel'][$key] : 'Model');
                        $ucModel = ucfirst($model);
                        $fkFunctions .= "\tpublic function {$model}Detail(){
                return \$this->belongsTo(\App\Models\\$ucModel::class, '$id');
            } \n";
                        $relations[] = "'{$model}Detail'";
                        $columns .= "->addColumn('$id', function (\$$project) {
                        return \$$project->{$model}Detail->" . (isset($_POST['skvalue'][$key]) ? $_POST['skvalue'][$key] : 'name') . ";})\n";
                    }
                } elseif ($type == 'secondary_key') {
                    // Ajouter la relation même si le champ n'est pas dans la grille
                    $model = strtolower(isset($_POST['skmodel'][$key]) ? $_POST['skmodel'][$key] : 'Model');
                    $ucModel = ucfirst($model);
                    $fkFunctions .= "\tpublic function {$model}Detail(){
                return \$this->belongsTo(\App\Models\\$ucModel::class, '$id');
            } \n";
                }
            }
        }
        if ($_POST["serverSide"] == 1) {
            $queryLine = "\$query = self::query()->where('deleted', '0');";
            if (!empty($relations)) {
                $relationsStr = implode(', ', $relations);
                $queryLine = "\$query = self::with([$relationsStr])->where('deleted', '0');";
            }

            $serverSide = "public static function getDataForDataTable()
            {
                $queryLine

                return DataTables::of(\$query)
                    $columns
                    ->addColumn('action', function (\$$project) {
                        return view('back.$project.actions', compact('$project'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }";
        }
        $castsString = !empty($casts) ? "\n\tprotected \$casts = [\n\t\t" . implode(",\n\t\t", $casts) . "\n\t];" : "";
        $contenu = str_replace('{FK}', $fkFunctions, $contenu);
        $contenu = str_replace('{CASTS}', $castsString, $contenu);
        $contenu = str_replace('{serverSide}', $serverSide, $contenu);


        $modelFile = fopen(base_path() . '/app/Models/' . ucfirst(strtolower($_POST['projet'])) . '.php', 'w+');
        fwrite($modelFile, $contenu);
        fclose($modelFile);
    }

    public static function genControllerFile()
    {
        // Normaliser les données POST
        self::normalizePostData();
        $contenu = file_get_contents(base_path() . "/packages/easycollab/quicky/src/Templates/Controller.php");
        $contenu = str_replace('{Model}', ucfirst(strtolower($_POST['projet'])), $contenu);
        $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
        $viewsData = "\n";
        $validationRules = "";
        $fileUploads = "";
        $serverSide = "";
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $type = $_POST['formElement'][$key];
                $required = isset($_POST['visible'][$key]) && $_POST['visible'][$key] == 1 ? 'required|' : 'nullable|';

                // Génération des règles de validation selon le type
                switch ($type) {
                    case 'primary_key':
                        // Pas de validation pour la clé primaire
                        break;
                    case 'secondary_key':
                        // Vérifier que le modèle existe et n'est pas vide
                        if (isset($_POST['skmodel'][$key]) && !empty($_POST['skmodel'][$key])) {
                            $model = strtolower($_POST['skmodel'][$key]);
                            $ucModel = ucfirst($model);
                            $viewsData .= "\t\t\$viewsData['{$model}Records'] = \App\Models\\$ucModel::all()->where('deleted','0');\n";
                            $validationRules .= "\t\t\t'$id' => '{$required}integer|exists:{$model}s,id',\n";
                        }
                        break;
                    case 'email':
                        $validationRules .= "\t\t\t'$id' => '{$required}email',\n";
                        break;
                    case 'number':
                        $validationRules .= "\t\t\t'$id' => '{$required}numeric',\n";
                        break;
                    case 'url':
                        $validationRules .= "\t\t\t'$id' => '{$required}url',\n";
                        break;
                    case 'phone':
                        $validationRules .= "\t\t\t'$id' => '{$required}string|max:20',\n";
                        break;
                    case 'datepicker':
                        $validationRules .= "\t\t\t'$id' => '{$required}date',\n";
                        break;
                    case 'file':
                        $validationRules .= "\t\t\t'$id' => '{$required}file|max:10240',\n";
                        $fileUploads .= "\t\t\tif (\$request->hasFile('$id')) {\n";
                        $fileUploads .= "\t\t\t\t\$data['$id'] = \$request->file('$id')->store('uploads', 'public');\n";
                        $fileUploads .= "\t\t\t}\n";
                        break;
                    case 'colorpicker':
                        $validationRules .= "\t\t\t'$id' => '{$required}string|size:7|regex:/^#[a-fA-F0-9]{6}$/',\n";
                        break;
                    case 'select_multiple':
                    case 'select_multiple_basic':
                    case 'checkbox':
                        // Pour les tableaux, si required, on doit avoir au moins 1 élément
                        $arrayRule = $required === 'required|' ? 'required|array|min:1' : 'nullable|array';
                        $validationRules .= "\t\t\t'$id' => '$arrayRule',\n";
                        break;
                    case 'password':
                        $validationRules .= "\t\t\t'$id' => '{$required}string|min:8',\n";
                        break;
                    case 'text':
                    case 'textarea':
                    case 'ckeditor':
                    case 'hidden':
                    case 'select':
                    case 'select_basic':
                    case 'radio':
                    default:
                        $size = isset($_POST['size'][$key]) && !empty($_POST['size'][$key]) ? $_POST['size'][$key] : 255;
                        $validationRules .= "\t\t\t'$id' => '{$required}string|max:$size',\n";
                        break;
                }
            }
        }
        if ($_POST["serverSide"] == 1) {
            $project = strtolower($_POST['projet']);
            $modelName = ucfirst(strtolower($_POST['projet']));
            $serverSide = "public function data()
            {
               return $modelName::getDataForDataTable();
            }";
        }

        $contenu = str_replace('{viewsData}', $viewsData, $contenu);
        $contenu = str_replace('{validationRules}', $validationRules, $contenu);
        $contenu = str_replace('{fileUploads}', $fileUploads, $contenu);
        $contenu = str_replace('{serverSide}', $serverSide, $contenu);


        $modelFile = fopen(base_path() . '/app/Http/Controllers/' . ucfirst(strtolower($_POST['projet'])) . 'Controller.php', 'w+');
        fwrite($modelFile, $contenu);
        fclose($modelFile);
    }

    public static function genMigrationFile($isUpdate = false)
    {
        // Normaliser les données POST
        self::normalizePostData();
        $columns = "";
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $type = $_POST['formElement'][$key];
                switch ($type) {
                    case "primary_key":
                        // Déjà géré par bigIncrements('id') dans le template
                        break;
                    case "secondary_key":
                        $columns .= "\t\t\t\$table->unsignedBigInteger('$id')->nullable(true);\n";
                        break;
                    case "ckeditor":
                    case "textarea":
                        $columns .= "\t\t\t\$table->longText('$id')->nullable(true);\n";
                        break;
                    case "number":
                        $columns .= "\t\t\t\$table->integer('$id')->nullable(true);\n";
                        break;
                    case "email":
                        $columns .= "\t\t\t\$table->string('$id')->nullable(true);\n";
                        break;
                    case "password":
                        $columns .= "\t\t\t\$table->string('$id')->nullable(true);\n";
                        break;
                    case "url":
                        $columns .= "\t\t\t\$table->text('$id')->nullable(true);\n";
                        break;
                    case "phone":
                        $columns .= "\t\t\t\$table->string('$id', 20)->nullable(true);\n";
                        break;
                    case "datepicker":
                        $columns .= "\t\t\t\$table->date('$id')->nullable(true);\n";
                        break;
                    case "timepicker":
                        $columns .= "\t\t\t\$table->time('$id')->nullable(true);\n";
                        break;
                    case "colorpicker":
                        $columns .= "\t\t\t\$table->string('$id', 7)->nullable(true);\n";
                        break;
                    case "file":
                        $columns .= "\t\t\t\$table->string('$id')->nullable(true);\n";
                        break;
                    case "hidden":
                        $columns .= "\t\t\t\$table->string('$id')->nullable(true);\n";
                        break;
                    case "select":
                    case "select_basic":
                    case "radio":
                        $columns .= "\t\t\t\$table->string('$id')->nullable(true);\n";
                        break;
                    case "select_multiple":
                    case "select_multiple_basic":
                    case "checkbox":
                        $columns .= "\t\t\t\$table->json('$id')->nullable(true);\n";
                        break;
                    case "text":
                    default:
                        $columns .= "\t\t\t\$table->string('$id')->nullable(true);\n";
                        break;
                }
            }
        }
        if ($isUpdate) {
            $contentPath = base_path() . "/packages/easycollab/quicky/src/Templates/Migration_update.php";
            $savePath = base_path() . '/database/migrations/' . date("Y_m_d_His") . "_" . strtolower($_POST['projet']) . "_table_update_fields.php";
        } else {
            $contentPath = base_path() . "/packages/easycollab/quicky/src/Templates/Migration.php";
            $savePath = base_path() . '/database/migrations/' . date("Y_m_d_His") . "_" . strtolower($_POST['projet']) . "_table.php";
        }
        $contenu = file_get_contents($contentPath);
        $contenu = str_replace('{Model}', ucfirst(strtolower($_POST['projet'])), $contenu);
        $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
        $contenu = str_replace('{Columns}', $columns, $contenu);

        $modelFile = fopen($savePath, 'w+');
        fwrite($modelFile, $contenu);
        fclose($modelFile);
    }

    public static function addProjectToList($project)
    {
        Quickyproject::create([
            'name' => $project,
            'id_project' => $project
        ]);
    }
}
