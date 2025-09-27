<?php

namespace EasyCollab\Quicky\Models;

use Illuminate\Database\Eloquent\Model;

class FormType
{
    public static function getFormCreateHtml($label, $id, $columns, $type = "text")
    {
        return self::getFormHtml($label, $id, $columns, $type, "{{ old('$id') }}");
    }

    public static function getFormUpdateHtml($label, $id, $columns, $type = "text")
    {
        return self::getFormHtml($label, $id, $columns, $type, "{{ old('$id', \$record->$id) }}");
    }

    private static function getFormHtml($label, $id, $columns, $type, $value)
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
            default:
                $inputField = "<input type=\"text\" name=\"$id\" id=\"$id\" class=\"$class\" placeholder=\"$label\" value=\"$value\" />";
                break;
        }

        return <<<HTML
            <div class="col-md-$columns">
                <label class="form-label" for="$id">$label</label>
                $inputField
                @error('$id')
                <span class="helper-text text-danger">{{ \$message }}</span>
                @enderror
            </div>
        HTML;
    }
}
