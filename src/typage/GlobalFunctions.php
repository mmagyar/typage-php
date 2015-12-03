<?php
use mmagyar\type\ArrayList;
use mmagyar\type\Boolean;
use mmagyar\type\Double;
use mmagyar\type\Either;
use mmagyar\type\Integer;
use mmagyar\type\Nullable;
use mmagyar\type\Number;
use mmagyar\type\Object;
use mmagyar\type\Text;
use mmagyar\type\Type;
use mmagyar\type\Union;

/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

//Composer autoloader must be loaded to use this file.

function boolean() {
    return new Boolean();
}

function number($min = null, $max = null) {
    return new Number($min, $max);
}

function integer($min = null, $max = null) {
    return new Integer($min, $max);
}

function double($min = null, $max = null) {
    return new Double($min, $max);
}

function arrayList(Type $memberType) {
    return new ArrayList($memberType);
}

function text($regex = null) {
    return new Text($regex);
}

function nullable(Type $type) {
    return new Nullable($type);
}

function object($content) {
    return new Object($content);
}

function either(Type $expected, $defaultValue, $defaultOnWrongType = false, $defaultOnNull = true) {
    return new Either($expected, $defaultValue, $defaultOnWrongType, $defaultOnNull);
}

function union(array $typeList) {
    return new Union($typeList);
}

