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
                foreach ($select_radio_key as $cle => $valeur) {
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
                foreach ($select_radio_key as $cle => $valeur) {
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
