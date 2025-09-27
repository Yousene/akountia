<?php

namespace EasyCollab\Quicky\Models;

use App\Models\Permission;
use App\Models\Quickyproject;
use EasyCollab\Quicky\Models\FormType;
use Illuminate\Database\Eloquent\Model;

class Quicky extends Model
{
    protected $table = 'users';

    public static function genListView()
    {

        $th = $td = $serverSide = "";
        $serverSideColumns = ["{data: '',}"];
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0 && $_POST['inGrid'][$key] == 1 && $_POST['formElement'][$key] != "primary_key") {

                $label = $_POST['Label'][$key];
                if ($_POST["serverSide"] == 1) {
                    $serverSideColumns[] = "{data:'$value', name:'$value'}";
                }
                $th .= "
                                            <th> $label </th>";
            }
        }

        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0 && $_POST['inGrid'][$key] == 1 && $_POST['formElement'][$key] != "primary_key") {
                $id = $_POST['Identifiant'][$key];
                $type = $_POST['formElement'][$key];
                switch ($type) {
                    case "secondary_key":
                        $skvalue = $_POST['skvalue'][$key];
                        $recordVar = strtolower($_POST['skmodel'][$key]) . "Detail";
                        $td .= "
                                            <td> {{ \$record->$recordVar->$skvalue }} </td>";
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
                        $skkey = $_POST['skkey'][$key];
                        $skvalue = $_POST['skvalue'][$key];
                        $recordVar = strtolower($_POST['skmodel'][$key]) . "Records";
                        $formTypes .= FormType::generateFormHtml($project, $label, $id, $columns, $type, $isUpdate, $recordVar, $skkey, $skvalue);

                        break;
                    case "select":
                        if (isset($_POST['Select_valeur'][$key])) {
                            $select_radio_value = $_POST['Select_valeur'][$key];
                            $select_radio_key = $_POST['Select_cle'][$key];
                            $formTypes .= FormType::generateFormHtml($project, $label, $id, $columns, $type, $isUpdate, null, null, null, $select_radio_key,$select_radio_value);
                        }
                        break;
                    case "radio":
                        if (isset($_POST['Radio_valeur'][$key])) {
                            $select_radio_value = $_POST['Radio_valeur'][$key];
                            $select_radio_key = $_POST['Radio_cle'][$key];
                            $formTypes .= FormType::generateFormHtml($project, $label, $id, $columns, $type, $isUpdate, null, null, null,$select_radio_key, $select_radio_value);
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

                        $skkey = $_POST['skkey'][$key];
                        $skvalue = $_POST['skvalue'][$key];
                        $recordVar = strtolower($_POST['skmodel'][$key]) . "Records";

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
                            foreach ($_POST['Select_valeur'][$key] as $cle => $valeur) {
                                $option_cle = $_POST['Select_cle'][$key][$cle];
                                $option_val = $_POST['Select_valeur'][$key][$cle];
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
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "phone");
                    case "textarea":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "textarea");
                        break;
                    case "ckeditor":
                        $formTypes .= FormType::getFormCreateHtml($label, $id, $columns, "phone");
                        break;
                    case "radio":
                        $formTypes .= "
                                    <div class=\"col-md-$columns \">
                                    <small class=\"text-light fw-medium\">$label</small>
                                ";
                        if (isset($_POST['Radio_valeur'][$key])) {
                            foreach ($_POST['Radio_valeur'][$key] as $cle => $valeur) {
                                $option_cle = $_POST['Radio_cle'][$key][$cle];
                                $option_val = $_POST['Radio_valeur'][$key][$cle];
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
                        $skkey = $_POST['skkey'][$key];
                        $skvalue = $_POST['skvalue'][$key];
                        $recordVar = strtolower($_POST['skmodel'][$key]) . "Records";

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
                            foreach ($_POST['Select_valeur'][$key] as $cle => $valeur) {
                                $option_cle = $_POST['Select_cle'][$key][$cle];
                                $option_val = $_POST['Select_valeur'][$key][$cle];
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
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "phone");
                    case "textarea":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "textarea");
                        break;
                    case "ckeditor":
                        $formTypes .= FormType::getFormUpdateHtml($label, $id, $columns, "phone");
                        break;

                    case "radio":
                        $formTypes .= "
                                    <div class=\"col-md-$columns \">
                                    <small class=\"text-light fw-medium\">$label</small>
                                ";
                        if (isset($_POST['Radio_valeur'][$key])) {
                            foreach ($_POST['Radio_valeur'][$key] as $cle => $valeur) {
                                $option_cle = $_POST['Radio_cle'][$key][$cle];
                                $option_val = $_POST['Radio_valeur'][$key][$cle];
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
        $contenu = file_get_contents(base_path() . "/packages/easycollab/quicky/src/Templates/Model.php");
        $contenu = str_replace('{CLASS_NAME}', ucfirst(strtolower($_POST['projet'])), $contenu);
        $contenu = str_replace('{TABEL_NAME}', strtolower($_POST['projet']) . 's', $contenu);
        $fkFunctions = "";
        $serverSide = "";
        $relations = [];
        $columns = "";
        $project = strtolower($_POST['projet']);
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $type = $_POST['formElement'][$key];

                if ($type == 'secondary_key') {
                    $model = strtolower($_POST['skmodel'][$key]);
                    $ucModel = ucfirst(strtolower($_POST['skmodel'][$key]));
                    $fkFunctions .= "\tpublic function {$model}Detail(){
            return \$this->belongsTo(\App\Models\\$ucModel::class, '$id');
        } \n";
                    $relations[] = "'{$model}Detail'";
                    $columns .= "->addColumn('$id', function (\$$project) {
                    return \$$project->{$model}Detail->" . $_POST['skvalue'][$key] . ";})\n";
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
        $contenu = str_replace('{FK}', $fkFunctions, $contenu);
        $contenu = str_replace('{serverSide}', $serverSide, $contenu);


        $modelFile = fopen(base_path() . '/app/Models/' . ucfirst(strtolower($_POST['projet'])) . '.php', 'w+');
        fwrite($modelFile, $contenu);
        fclose($modelFile);
    }

    public static function genControllerFile()
    {
        $contenu = file_get_contents(base_path() . "/packages/easycollab/quicky/src/Templates/Controller.php");
        $contenu = str_replace('{Model}', ucfirst(strtolower($_POST['projet'])), $contenu);
        $contenu = str_replace('{projetId}', strtolower($_POST['projet']), $contenu);
        $viewsData = "\n";
        $serverSide = "";
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $type = $_POST['formElement'][$key];

                if ($type == 'secondary_key') {
                    $model = strtolower($_POST['skmodel'][$key]);
                    $ucModel = ucfirst(strtolower($_POST['skmodel'][$key]));
                    $viewsData .= "\t\t\$viewsData['{$model}Records'] = \App\Models\\$ucModel::all()->where('deleted','0');\n";
                }
            }
        }
        if ($_POST["serverSide"] == 1) {
            $project = strtolower($_POST['projet']);
            $serverSide = "public function data()
            {
               return $project::getDataForDataTable();
            }";
        }

        $contenu = str_replace('{viewsData}', $viewsData, $contenu);
        $contenu = str_replace('{serverSide}', $serverSide, $contenu);


        $modelFile = fopen(base_path() . '/app/Http/Controllers/' . ucfirst(strtolower($_POST['projet'])) . 'Controller.php', 'w+');
        fwrite($modelFile, $contenu);
        fclose($modelFile);
    }

    public static function genMigrationFile($isUpdate = false)
    {
        $columns = "";
        foreach ($_POST['Identifiant'] as $key => $value) {
            if ($_POST['del'][$key] == 0) {
                $id = $_POST['Identifiant'][$key];
                $type = $_POST['formElement'][$key];
                switch ($type) {
                    case "ckeditor":
                    case "textarea":
                        $columns .= "\t\t\t\$table->longText('$id')->nullable(true);\n";
                        break;
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
