<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;


/**
 * Class Either
 * Wrap another Type class in this to make it optional with a default value
 *
 * @package Sicom\Sems\Type
 */
class Nullable extends Type {

    /** @var  Type */
    private $type;

    public function __construct(Type $type) {
        $described = $type->getTypeDescription()->describe();

        $described[static::$propertyPrefix . 'allowNull'] = true;
        parent::__construct(new TypeDescription("", $described));
        $this->type = $type;
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

        if ($value === null) {
            return null;
        }

        return $this->type->check($value, $variableName, $soft);
    }
}
