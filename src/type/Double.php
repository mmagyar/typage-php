<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\type;

use InvalidArgumentException;

final class Double extends Number {
    protected $typeName = "Double";

     final protected function subTypeCheck($value, $variableName, $soft) {
         //TODO should integer be accepted as double?
         if (!is_numeric($value)) {
//             if (!is_float($value)) {
            if ($soft) {
                return None::getInstance();
            }
            throw new InvalidArgumentException(
                "Type must be double(float), type of value named: $variableName given: " .
                gettype($value) .
                " with data: " . static::safePrint($value)
            );
        }

        return floatval($value);
    }

}
