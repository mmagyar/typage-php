<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\type;

use InvalidArgumentException;


class ArrayList extends Collection {

    protected $childrenType;

    /**
     * ArrayList constructor.
     *
     * @param Type|null $arrayMemberType , if it's not null, every element will be validated for type
     */
    public function __construct(Type $arrayMemberType = null) {
        $type = new TypeDescription("Array", ["items" => $arrayMemberType->getTypeDescription()]);
        parent::__construct($type, false);
        $this->childrenType = $arrayMemberType;
    }

    function dataTypeCheck($value, $variableName, $soft) {
        if (!is_array($value)) {
            if ($soft) {
                return None::getInstance();
            }

            throw new InvalidArgumentException(
                "Type must be array, type of value named: $variableName given: " . gettype($value) .
                " with data: " . static::safePrint($value)
            );
        }

        if ($this->childrenType !== null) {
            foreach ($value as $key => $element) {
                $this->childrenType->check($element, "{$variableName}[{$key}]");
            }
        }

        return $value;
    }
}
