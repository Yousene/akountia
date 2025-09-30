<?php

namespace EasyCollab\Quicky\Models;

use Illuminate\Database\Eloquent\Model;

class FormType
{
    public static function generateFormHtml($project, $label, $id, $columns, $type, $isUpdate = false, $recordVar = null, $skkey = null, $skvalue = null, $select_radio_key = null, $select_radio_value = null, $key = null)
    {
        $value = $isUpdate ? "{{ old('$id', \$record->$id) }}" : "{{ old('$id') }}";
        $can = $isUpdate ? $project . "." . $id . ".update" : $project . "." . $id . ".create";
        return self::getFormHtml($isUpdate, $label, $id, $columns, $type, $value, $can, $recordVar, $skkey, $skvalue, $select_radio_key, $select_radio_value, $key);
    }

    public static function getFormCreateHtml($label, $id, $columns, $type = "text")
    {
        return self::getFormHtml(false, $label, $id, $columns, $type, "{{ old('$id') }}", "", null, null, null, null, null, null);
    }

    public static function getFormUpdateHtml($label, $id, $columns, $type = "text")
    {
        return self::getFormHtml(true, $label, $id, $columns, $type, "{{ old('$id', \$record->$id) }}", "", null, null, null, null, null, null);
    }

    private static function getFormHtml($isUpdate, $label, $id, $columns, $type, $value, $can, $recordVar = null, $skkey = null, $skvalue = null, $select_radio_key = null, $select_radio_value = null, $key = null)
    {
        $inputField = "";
        $class = "form-control";
        switch ($type) {
            case 'text':
                $inputField = "<input type=\"text\" name=\"$id\" id=\"$id\" class=\"$class\" placeholder=\"$label\" value=\"$value\" />";
                break;
            case 'datepicker':
                $inputField = "<input type=\"text\" class=\"$class quicky-date\" placeholder=\"YYYY-MM-DD\" id=\"$id\" name=\"$id\" value=\"$value\" />";
                break;
            case 'timepicker':
                $inputField = "<input type=\"text\" class=\"$class quicky-time\" placeholder=\"HH:MM\" id=\"$id\" name=\"$id\" value=\"$value\" />";
                break;
            case 'textarea':
                $inputField = "<textarea class=\"$class\" id=\"$id\" name=\"$id\" rows=\"3\">$value</textarea>";
                break;
            case 'secondary_key':
                $select_value = $isUpdate ? "{{ \$row->$skkey == old('$id', \$record->$id) ? 'selected' : '' }}" : "{{ \$row->$skkey == old('$id') ? 'selected' : '' }}";
                $inputField = <<<HTML
                <select name="$id" id="$id" class="select2 $class" data-allow-clear="true">
                    @foreach (\$$recordVar as \$row)
                    <option class="option" $select_value value="{{ \$row->$skkey }}"> {{ \$row->$skvalue }}</option>
                    @endforeach
                </select>
                HTML;
                break;
            case 'select':
                $select_options = "";
                foreach ((array)$select_radio_key as $cle => $valeur) {
                    $option_cle = $select_radio_key[$cle];
                    $option_val = $select_radio_value[$cle];
                    $select_value = $isUpdate ? "{{(\$record->$id == '$option_cle') ? 'selected' : ''}}" : "";
                    $select_options .= <<<HTML
                    <option value="$option_cle" $select_value> $option_val </option> \n"
                    HTML;
                }
                $inputField = <<<HTML
                    <select name="$id" id="$id" class="select2 $class" data-allow-clear="true">
                        $select_options
                    </select>
                HTML;
                break;
            case 'radio':
                foreach ((array)$select_radio_key as $cle => $valeur) {
                    $option_cle = $select_radio_key[$cle];
                    $option_val = $select_radio_value[$cle];
                    $radio_value = $isUpdate ? "{{(\$record->$id == '$option_cle') ? 'checked' : ''}}" : "";
                    $inputField .= <<<HTML
                            <div class="form-check">
                                <input name="$id" class="form-check-input" $radio_value type="radio" value="$option_cle" id="radio_$cle">
                                <label class="form-check-label" for="radio_$cle"> $option_val </label>
                            </div>
                    HTML;
                }
                break;
            case 'checkbox':
                foreach ((array)$select_radio_key as $cle => $valeur) {
                    $option_cle = $select_radio_key[$cle];
                    $option_val = $select_radio_value[$cle];
                    // Pour les checkbox, on vérifie si la valeur est dans le tableau JSON
                    $checkbox_value = $isUpdate ? "{{(is_array(\$record->$id) && in_array('$option_cle', \$record->$id)) ? 'checked' : ''}}" : "";
                    $inputField .= <<<HTML
                            <div class="form-check">
                                <input name="{$id}[]" class="form-check-input" $checkbox_value type="checkbox" value="$option_cle" id="checkbox_{$id}_{$cle}">
                                <label class="form-check-label" for="checkbox_{$id}_{$cle}"> $option_val </label>
                            </div>
                    HTML;
                }
                break;
            case 'select_basic':
                $select_options = "";
                foreach ((array)$select_radio_key as $cle => $valeur) {
                    $option_cle = $select_radio_key[$cle];
                    $option_val = $select_radio_value[$cle];
                    $select_value = $isUpdate ? "{{(\$record->$id == '$option_cle') ? 'selected' : ''}}" : "";
                    $select_options .= <<<HTML
                    <option value="$option_cle" $select_value> $option_val </option> \n"
                    HTML;
                }
                $inputField = <<<HTML
                    <select name="$id" id="$id" class="$class">
                        $select_options
                    </select>
                HTML;
                break;
            case 'select_multiple':
                $select_options = "";
                foreach ((array)$select_radio_key as $cle => $valeur) {
                    $option_cle = $select_radio_key[$cle];
                    $option_val = $select_radio_value[$cle];
                    $select_value = $isUpdate ? "{{(\$record->$id == '$option_cle') ? 'selected' : ''}}" : "";
                    $select_options .= <<<HTML
                    <option value="$option_cle" $select_value> $option_val </option> \n"
                    HTML;
                }
                $inputField = "<select name=\"{$id}[]\" id=\"$id\" class=\"select2 $class\" multiple data-allow-clear=\"true\">$select_options</select>";
                break;
            case 'select_multiple_basic':
                $select_options = "";
                foreach ((array)$select_radio_key as $cle => $valeur) {
                    $option_cle = $select_radio_key[$cle];
                    $option_val = $select_radio_value[$cle];
                    $select_value = $isUpdate ? "{{(\$record->$id == '$option_cle') ? 'selected' : ''}}" : "";
                    $select_options .= <<<HTML
                    <option value="$option_cle" $select_value> $option_val </option> \n"
                    HTML;
                }
                $inputField = "<select name=\"{$id}[]\" id=\"$id\" class=\"$class\" multiple>$select_options</select>";
                break;
            case 'ckeditor':
                $inputField = "<textarea class=\"$class ckeditor\" id=\"$id\" name=\"$id\" rows=\"5\">$value</textarea>";
                break;
            case 'colorpicker':
                $inputField = "<input type=\"color\" name=\"$id\" id=\"$id\" class=\"$class\" value=\"$value\" />";
                break;
            case 'file':
                $existingFileDisplay = '';
                if ($isUpdate) {
                    $existingFileDisplay = <<<HTML
                    @if(\$record->$id)
                        <div class="existing-file mb-2">
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="bx bx-file me-2"></i>
                                <div>
                                    <strong>Fichier actuel:</strong>
                                    <a href="{{ Storage::url(\$record->$id) }}" target="_blank" class="ms-2">
                                        {{ basename(\$record->$id) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    HTML;
                }
                $inputField = <<<HTML
                <div class="file-upload-container">
                    $existingFileDisplay
                    <input type="file" name="$id" id="$id" class="$class file-input" onchange="previewFile(this, '$id')" accept="*/*" />
                    <div id="preview-$id" class="file-preview mt-2" style="display: none;">
                        <div class="preview-content">
                            <img id="img-preview-$id" src="" alt="Preview" style="max-width: 200px; max-height: 200px; object-fit: contain; border-radius: 8px; border: 1px solid #ddd; display: none;" />
                            <div id="file-info-$id" class="file-info mt-2">
                                <span class="file-name badge bg-light text-dark"></span>
                                <span class="file-size badge bg-info ms-2"></span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="clearPreview('$id')">
                            <i class="bx bx-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
                HTML;
                break;
            case 'phone':
                $inputField = "<input type=\"tel\" name=\"$id\" id=\"$id\" class=\"$class\" placeholder=\"$label\" value=\"$value\" />";
                break;
            case 'email':
                $inputField = "<input type=\"email\" name=\"$id\" id=\"$id\" class=\"$class\" placeholder=\"$label\" value=\"$value\" />";
                break;
            case 'number':
                $inputField = "<input type=\"number\" name=\"$id\" id=\"$id\" class=\"$class\" placeholder=\"$label\" value=\"$value\" />";
                break;
            case 'password':
                $inputField = "<input type=\"password\" name=\"$id\" id=\"$id\" class=\"$class\" placeholder=\"$label\" value=\"$value\" />";
                break;
            case 'url':
                $inputField = "<input type=\"url\" name=\"$id\" id=\"$id\" class=\"$class\" placeholder=\"$label\" value=\"$value\" />";
                break;
            case 'hidden':
                $inputField = "<input type=\"hidden\" name=\"$id\" id=\"$id\" value=\"$value\" />";
                break;
            default:
                $inputField = "<input type=\"text\" name=\"$id\" id=\"$id\" class=\"$class\" placeholder=\"$label\" value=\"$value\" />";
                break;
        }

        $field = <<<HTML
            @can('$can')
            <div class="col-md-$columns">
                <label class="form-label" for="$id">$label</label>
                $inputField
                @error('$id')
                <span class="helper-text text-danger">{{ \$message }}</span>
                @enderror
            </div>
            @endcan
         HTML;
        return $field;
    }
}
