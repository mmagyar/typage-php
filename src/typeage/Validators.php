<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;

//this is for backwards compatibility since under php 5.6 you cannot import functions from namespaces

class Validators {

    public  function boolean() {
        return new Boolean();
    }

    public  function number($min = null, $max = null) {
        return new Number($min, $max);
    }

    public  function integer($min = null, $max = null) {
        return new Integer($min, $max);
    }

    public  function double($min = null, $max = null) {
        return new Double($min, $max);
    }

    public  function arrayList(Type $memberType) {
        return new ArrayList($memberType);
    }

    public  function text($regex = null) {
        return new Text($regex);
    }

    public  function nullable(Type $type) {
        return new Nullable($type);
    }

    public  function object($content) {
        return new Object($content);
    }

    public  function either(Type $expected, $defaultValue, $defaultOnWrongType = false, $defaultOnNull = true) {
        return new Either($expected, $defaultValue, $defaultOnWrongType, $defaultOnNull);
    }

    public  function union(array $typeList) {
        return new Union($typeList);
    }


}

