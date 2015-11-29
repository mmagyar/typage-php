<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\type;

use InvalidArgumentException;


class Text extends AbstractAny {

    protected $validatorRegex = "";

    //TODO maybe add min and maximum length
    public function __construct($validatorRegex = null) {

        $accepted = [];
        if ($validatorRegex) {
            $accepted[static::$propertyPrefix . 'regex'] = $validatorRegex;
        }
        parent::__construct(New TypeDescription("Text", $accepted));
        $this->validatorRegex = $validatorRegex;
    }

    final protected function dataTypeCheck($value, $variableName, $soft) {
        if (!is_string($value)) {
            if ($soft) return None::getInstance();


            throw new InvalidArgumentException(
                "Type must be String, type of value named: $variableName given: " . gettype($value) .
                " with data: " . static::safePrint($value)
            );
        }

        if ($this->validatorRegex !== null && !preg_match($this->validatorRegex, $value)) {
            if ($soft) return None::getInstance();
            throw new InvalidArgumentException(
                "Value named: $variableName with data: \"$value\" does not conform to regex: $this->validatorRegex"
            );
        }


        return $this->additionalCheck($value, $variableName, $soft);
    }

    protected function additionalCheck($value, $variableName, $soft) {
        return $value;
    }
}
