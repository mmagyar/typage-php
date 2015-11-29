<?php
use mmagyar\mmmcms\type\ArrayList;
use mmagyar\mmmcms\type\Boolean;
use mmagyar\mmmcms\type\Double;
use mmagyar\mmmcms\type\Either;
use mmagyar\mmmcms\type\Integer;
use mmagyar\mmmcms\type\Nullable;
use mmagyar\mmmcms\type\Number;
use mmagyar\mmmcms\type\Object;
use mmagyar\mmmcms\type\Text;
use mmagyar\mmmcms\type\Type;
use mmagyar\mmmcms\type\Union;

/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */


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

