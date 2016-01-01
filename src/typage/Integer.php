<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;


final class Integer extends Number {

    protected $typeName = "Integer";

    final public function subTypeCheck($value, $variableName, $soft) {
        //Type coercion works here, because at this point we already made sure that what we have is a number, even if it's in a string
        if ((static::$strictNumberCheck && !is_int($value)) || (!static::$strictNumberCheck && !is_int($value + 0)))
            return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);

        return intval($value);
    }

}
