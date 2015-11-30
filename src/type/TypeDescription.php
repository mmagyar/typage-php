<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\type;


use InvalidArgumentException;

class TypeDescription {
    private $additionalFields;
    private $typeName;

    /**
     * TypeDescription constructor.
     * @param string       $typename
     * @param string|array $additionalFields
     */
    public function __construct($typename, $additionalFields = array()) {
        $this->typeName         = $typename;
        $this->additionalFields = $additionalFields;
    }

    public function describe() {
        $description = $this->createDescribe($this->additionalFields, true);

        if ($this->typeName) {
            if (isset($description[Type::$propertyPrefix . "type"]))
                throw new InvalidArgumentException("Additional fields can not contain key '" . Type::$propertyPrefix . "type'");
            $typeNameArray = [Type::$propertyPrefix . 'type' => $this->typeName];
            $description   = $description !== null ? array_merge($typeNameArray, $description) : $typeNameArray;
        }

        return $description;
    }

    protected function  createDescribe($value, $mustBeArray = false) {
        if ($value instanceof TypeDescription) {
            return $value->describe();
        } else if ($value instanceof Type) {
            return $value->getTypeDescription()->describe();
        } else if (is_array($value)) {
            return array_map(array($this, 'createDescribe'), $value);
        }

        if ($mustBeArray && $value !== null) throw new InvalidArgumentException(
            "createDescribe was called with a non array|Type|TypeDescription|null parameter"
        );

        return $value;
    }

    public function __toString() {
        return json_encode($this->describe(), JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION);
    }
}
