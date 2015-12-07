<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;


final class Double extends Number {
    protected $typeName = "Double";

    final protected function subTypeCheck($value, $variableName, $soft) {
        //TODO should integer be accepted as double?
        if (!is_numeric($value))  //if (!is_float($value)) {
            return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);

        return floatval($value);
    }

}
