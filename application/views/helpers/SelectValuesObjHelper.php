<?php

class Zend_View_Helper_SelectValuesObjHelper extends Zend_View_Helper_Abstract
{

    public function selectValuesObjHelper($name, $values, $value, $oname, $ovalue)
    {
        $html = "<select name='" . $name . "'>";
        $selected = false;
        foreach ($values as $obj) {
            $getter = "get" . ucfirst($oname);
            $v = $obj->{
            $getter
            }();
            $getter = "get" . ucfirst($ovalue);
            $desc = $obj->{
            $getter
            }();
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
