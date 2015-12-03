<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;

/**
 * Class Either
 * Wrap another Type class in this to make it optional with a default value
 *
 * @package Sicom\Sems\Type
 */
class Either extends Type {

    /** @var  Type */
    private $type;
    private $defaultValue;
    private $defaultOnWrongType;
    private $defaultOnNull;


    public function __construct(Type $type, $defaultValue, $defaultOnWrongType = false, $defaultOnNull = true) {
        parent::__construct(
            new TypeDescription(
                "Either",
                [
                    static::$propertyPrefix . "expected"           => $type->getTypeDescription()->describe(),
                    static::$propertyPrefix . "orDefault"          => $defaultValue,
                    static::$propertyPrefix . "defaultOnWrongType" => $defaultOnWrongType,
                    static::$propertyPrefix . "defaultOnNull"      => $defaultOnNull
                ]
            )
        );

        $this->defaultValue       = $defaultValue;
        $this->defaultOnWrongType = $defaultOnWrongType;
        $this->defaultOnNull      = $defaultOnNull;
        $this->type               = $type;
    }

    /**
     * This method checks if $value confirms to Type, if $value does not confirm to type, throws an exception or returns null if $soft is true
     *
     * @param            $value
     * @param string     $variableName Used in the message of the Exception, to ease debugging
     * @param bool       $soft
     *
     * @return mixed
     */
    public function check($value, $variableName = "unknown", $soft = false) {
        if ($value === null && $this->defaultOnNull) {
            return $this->defaultValue;
        }

        $result = $this->type->check($value, $variableName, $this->defaultOnWrongType);
        if ($result instanceof None) {
            return $this->defaultValue;
        }

        return $result;
    }
}
