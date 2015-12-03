<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;


class None extends Type {

    /**
     * @var Type
     */
    protected static $simpleChecker;

    public static function getInstance() {
        if (static::$simpleChecker === null) {
            //This is not exactly safe, maybe it's better to remove this
            static::$simpleChecker = new static();
        }

        return static::$simpleChecker;
    }

    public function __construct() {
        parent::__construct(new TypeDescription("None", null));
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
        return null;
    }
}
