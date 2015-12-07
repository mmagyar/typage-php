<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\typage;


abstract class AbstractAny extends Type {

    private $allowNull = false;

    /**
     *
     * @param TypeDescription $typeDescription
     * @param bool            $allowNull
     */
    public function __construct(TypeDescription $typeDescription, $allowNull = false) {
        parent::__construct($typeDescription);
        $this->allowNull = $allowNull;
    }

    final public function check($value, $variableName = "unknown", $soft = false) {
        if ($this->allowNull && $value === null) return $value;

        if (!$this->allowNull && $value === null)
            return static::handleTypeError($this->getTypeString(), $value, $variableName, $soft);

        return $this->dataTypeCheck($value, $variableName, $soft);
    }


    abstract protected function dataTypeCheck($value, $variableName, $soft);

    /**
     * @return boolean
     */
    public function isNullAllowed() {
        return $this->allowNull;
    }
}
