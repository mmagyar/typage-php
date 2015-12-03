<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;

use Closure;
use InvalidArgumentException;


class Any extends AbstractAny {

    private $validatorFunction;

    /**
     * Any constructor.
     * Use this class if you do not need to validate for type, and optionally allow null.
     *
     * @param TypeDescription $description
     * @param Closure         $validatorFunction
     * @param bool            $allowNull
     */
    public function __construct(
        TypeDescription $description,
        Closure $validatorFunction = null,
        $allowNull = false
    ) {
        parent::__construct($description, $allowNull);
        $this->validatorFunction = $validatorFunction;
    }


    /**
     * @return Closure
     */
    public function getValidatorFunction() {
        return $this->validatorFunction;
    }


    final function dataTypeCheck($value, $variableName, $soft) {
        $validator = $this->validatorFunction;
        if ($validator !== null) {
            return $validator($value, $variableName, $soft);
        }

        return $value;
    }
}
