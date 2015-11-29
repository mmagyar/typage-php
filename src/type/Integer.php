<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\type;

use InvalidArgumentException;

final class Integer extends Number {

    protected $typeName = "Integer";

    final public function subTypeCheck($value, $variableName, $soft) {
        if (!is_int($value)) {
            if ($soft) {
                return None::getInstance();
            }
            throw new InvalidArgumentException(
                "Type must be int, type of value named: $variableName given: " .
                gettype($value) .
                " with data: " . static::safePrint($value)
            );
        }

        return intval($value);
    }

}
