<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */


namespace mmagyar\type;

use InvalidArgumentException;


/**
 * Class Either
 * Wrap another Type class in this to make it optional with a default value
 *
 * @package Sicom\Sems\Type
 */
class Union extends AbstractAny {

    /** @var  Type */
    private $types;


    /**
     * Union constructor.
     *
     * @param Type[] $acceptedTypes
     */
    public function __construct(array $acceptedTypes) {
        $i           = 0;
        $description = [];
        foreach ($acceptedTypes as $value) {
            $description[static::$propertyPrefix . "type_" . ($i++)] = $value;
        }
        $this->types = $acceptedTypes;
        parent::__construct(new TypeDescription("Union", $description), false);
    }


    protected function dataTypeCheck($value, $variableName, $soft) {
        foreach ($this->types as $type) {
            $result = $type->check($value, $variableName, true);
            if (!($result instanceof None)) return $result;
        }

        return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);
    }
}
