<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;

use InvalidArgumentException;

final class Integer extends Number {

    protected $typeName = "Integer";

    final public function subTypeCheck($value, $variableName, $soft) {
        if (!is_int($value))
            return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);

        return intval($value);
    }

}
