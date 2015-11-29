<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\type;

use InvalidArgumentException;


final class Boolean extends AbstractAny {

    public function __construct() {
        parent::__construct(new TypeDescription("Boolean"), false);
    }

    final function dataTypeCheck($value, $variableName, $soft) {
        if (!is_bool($value)) {
            if ($soft) {
                return None::getInstance();
            }

            throw new InvalidArgumentException(
                "Type must be Boolean, type of value named: $variableName given: " . gettype($value) .
                " with data: " . static::safePrint($value)
            );
        }

        return $value;
    }
}

