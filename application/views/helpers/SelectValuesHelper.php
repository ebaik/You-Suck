<?php

class Zend_View_Helper_SelectValuesHelper extends Zend_View_Helper_Abstract
{
    public function selectValuesHelper($name, $values, $value)
    {
        $html = "<select name='" . $name . "'>";
        $selected = false;
        foreach ($values as $v => $desc) {
            if ($value == $v && !$selected) {
                $selected = true;
                $html .= "<option value='" . $v . "' selected>" . $desc . "</option>";
            } else {
                $html .= "<option value='" . $v . "'>" . $desc . "</option>";
            }
        }
        $html .= "</select>";
        return $html;
    }

}

