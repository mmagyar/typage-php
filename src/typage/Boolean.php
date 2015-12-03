<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;

use InvalidArgumentException;


final class Boolean extends AbstractAny {

    public function __construct() {
        parent::__construct(new TypeDescription("Boolean"), false);
    }

    final function dataTypeCheck($value, $variableName, $soft) {
        if (!is_bool($value))
            return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);

        return $value;
    }
}

