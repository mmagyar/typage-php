<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;

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
        if (!is_array($value))
            return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);

        if ($this->childrenType !== null) {
            foreach ($value as $key => $element) {
                $result = $this->childrenType->check($element, "$variableName:[{$key}]", $soft);
                if ($result instanceof None) return $result;
            }
        }

        return $value;
    }
}
