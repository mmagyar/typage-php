<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\type;


use InvalidArgumentException;

class TypeDescription {
    private $possibleValues;
    private $typeName;

    /**
     * TypeDescription constructor.
     * @param string       $typename
     * @param string|array $additionalFields
     */
    public function __construct($typename, $additionalFields = array()) {
        $this->typeName       = $typename;
        $this->possibleValues = $additionalFields;
    }

    public function describe() {
        $description = $this->createDescribe($this->possibleValues);

        if ($this->typeName) {
            if (isset($description[Type::$propertyPrefix . "type"]))
                throw new InvalidArgumentException("Additional fields can not contain key '" . Type::$propertyPrefix . "type'");
            $description[Type::$propertyPrefix . 'type'] = $this->typeName;
        }
//        return [$this->typeName => $this->createDescribe($this->possibleValues)];
        return $description;
    }

    protected function  createDescribe($value) {
        if ($value instanceof TypeDescription) {
            return $value->describe();
        } else if ($value instanceof Type) {
            return $value->getTypeDescription()->describe();
        } else if (is_array($value)) {
            return array_map(array($this, 'createDescribe'), $value);
        }

//        return ["__value_literal" => $value];
        return $value;

    }

    public function __toString() {
        return json_encode($this->describe(), JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION);
    }
}
