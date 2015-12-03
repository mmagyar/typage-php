<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */


namespace mmagyar\typage;

use InvalidArgumentException;


class Number extends AbstractAny {

    private $min;
    private $max;

    protected $typeName = "Number";
    public static $strictNumberCheck = false;

    /**
     * Number constructor.
     * Can be used to check if a value is number, and in range, even if it's in a string
     *
     * @param number $minimumValue inclusive minimum value for the variable, not checked if null
     * @param number $maximumValue inclusive maximum value for the variable, not checked if null
     */
    public function __construct(
        $minimumValue = null,
        $maximumValue = null
    ) {
        $description = [];
        if ($minimumValue !== null) $description[static::$propertyPrefix . 'minimum'] = $minimumValue;
        if ($maximumValue !== null) $description[static::$propertyPrefix . 'maximum'] = $maximumValue;


        parent::__construct(new TypeDescription($this->typeName, $description), false);

        $this->min = $minimumValue;
        $this->max = $maximumValue;
    }

    protected function checkRange($value, $variableName, $soft) {
        if ($this->min !== null && floatval($value) < $this->min) {
            if ($soft) return false;
            throw new InvalidArgumentException(
                "Value named: $variableName has a value of " . strval($value) .
                " which is smaller then the minimum: " . strval($this->min)
            );
        }

        if ($this->max !== null && floatval($value) > $this->max) {
            if ($soft) return false;
            throw new InvalidArgumentException(
                "Value named: $variableName has a value of " . strval($value) .
                " which is bigger then the maximum: " . strval($this->max)
            );
        }
        return true;
    }

    final protected function dataTypeCheck($value, $variableName, $soft) {
        if (!is_numeric($value) || (static::$strictNumberCheck && is_string($value)))
            return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);



        if (!$this->checkRange($value, $variableName, $soft)) {
            return None::getInstance();
        }


        return $this->subTypeCheck($value, $variableName, $soft);
    }

    protected function  subTypeCheck($value, $variableName, $soft) {
        return $value;
    }
}
