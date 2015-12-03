<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;

use InvalidArgumentException;
use stdClass;

/**
 * Class Type
 *
 * @package Sicom\Sems\Type
 */
abstract class Type {

    /**
     * This should be set only once, before using this validation system
     * @var string
     */
    public static $propertyPrefix = "";


    /**
     * returns a var_dump of a variable as a string
     *
     * @param  mixed $value
     *
     * @return string
     */
    public static function safePrint($value) {
        ob_start();
        var_dump($value);

        return ob_get_clean();
    }

    /** @var TypeDescription */
    private $typeDescription;

    protected function __construct(TypeDescription $typeDescription) {
        $this->typeDescription = $typeDescription;
    }

    public static function handleTypeError($expectedType, $value,$variableName,$soft){
        if ($soft) return new None();

        $errorString = "Type must be " . $expectedType .
        ", type of value named `$variableName`: " . gettype($value) .
        " with data: " . static::safePrint($value);

        throw new InvalidArgumentException($errorString);
    }

    /**
     * This method checks if $value confirms to Type, if $value does not confirm to type, throws an exception or returns null if $soft is true
     *
     * @param            $value
     * @param string     $variableName Used in the message of the Exception, to ease debugging
     * @param bool       $soft
     *
     * @return mixed|None returns the (possibly) transformed, corrected, defaulted value, or returns None, if an error occures and $soft is set to true
     */
    public abstract function check($value, $variableName = "unknown", $soft = false);

    public function __toString() {
        return $this->typeDescription->__toString();
    }

    /** @return string */
    public function getTypeString() {
        return $this->typeDescription->__toString();
    }

    /** @return TypeDescription */
    public function getTypeDescription() {
        return $this->typeDescription;
    }

}
