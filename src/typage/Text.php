<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;

use InvalidArgumentException;


class Text extends AbstractAny {

    protected $validatorRegex = "";

    /**
     * String length properties matching deliberately, You can check string length with regex.
     * Length regex : /^.{8,10}$/ // matches any string between 8 and 10 characters
     * Or: /^.{8,10}$/s matches any string between 8 and 10 characters, including new line characters
     * Text constructor.
     * @param null|string $validatorRegex
     */
    public function __construct($validatorRegex = null) {

        $accepted = [];
        if ($validatorRegex) {
            $accepted[static::$propertyPrefix . 'regex'] = $validatorRegex;
        }
        parent::__construct(New TypeDescription("Text", $accepted));
        $this->validatorRegex = $validatorRegex;
    }

    final protected function dataTypeCheck($value, $variableName, $soft) {
        if (!is_string($value))
            return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);

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
