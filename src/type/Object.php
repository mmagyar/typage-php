<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */

namespace mmagyar\type;

use InvalidArgumentException;


class Object extends AbstractAny {

    private $childrenType;

    /**
     * ArrayList constructor.
     *
     * @param Type[]|null $arrayMemberType , if it's not null, every element  will be required and validated for type
     */
    public function __construct(array $arrayMemberType = null) {
        $description = [];
        foreach ($arrayMemberType as $key => $value) {
            $description[$key] = $value->getTypeDescription();
        }
        parent::__construct(new TypeDescription("Object", ["properties"=>$description]), false);
        $this->childrenType = $arrayMemberType;
    }

    public function get($arguments, $name, $soft = false) {
        if (!array_key_exists($name, $this->childrenType)) {
            throw new InvalidArgumentException("This Object does not have property: $name");
        }

        $isObject = is_object($arguments);
        $isArray = is_array($arguments);

        if (!($isArray || $isObject)) {
            throw new InvalidArgumentException("\$arguments must be an array or an object");
        }

        if ($isArray && array_key_exists($name, $arguments)) {
            $value = $arguments[$name];
        } else if ($isObject && property_exists($this->childrenType, $name)) {
            $value = $arguments->{$name};
        } else {
            throw new InvalidArgumentException("Property $name does not exist on \$arguments ");
        }

        return $this->childrenType[$name]->check($value, $name, $soft);
    }

    public function createGetter($arguments) {
        return function ($name) use ($arguments) {
            return $this->check($arguments, $name);
        };
    }

    protected function dataTypeCheck($value, $variableName, $soft) {
        $isObject = is_object($value);
        $isArray = is_array($value);
        if (!($isObject || $isArray)) {
            if ($soft) {
                return None::getInstance();
            }

            throw new InvalidArgumentException(
                "Type must be object, type of value named: $variableName given: " . gettype($value) .
                " with data: " . static::safePrint($value)
            );
        }

        //Set missing fields to null, let the child type check if it accepts it.
        foreach ($this->childrenType as $key => $element) {
            if ($isArray && !array_key_exists($key, $value)) {
                $value[$key] = null;
            } else if ($isObject && !property_exists($value, $key)) {
                $value->{$key} = null;
            }
            //throw new InvalidArgumentException("Required property: $key is missing from object: $variableName");
        }

        if ($this->childrenType !== null) {
            foreach ($value as $key => $element) {
                if (!isset($this->childrenType[$key])) {
                    throw new InvalidArgumentException(
                        "Property $key in array: $variableName does not have a validator Type"
                    );
                }

                //$actualValue = $this->childrenType[$key]->check($element, "{$variableName}:{{$key}}");
                $actualValue = $this->childrenType[$key]->check($element, "{$variableName}:{$key}");

                if ($isArray) {
                    $value[$key] = $actualValue;
                } else {
                    $value->{$key} = $actualValue;
                }
            }
        }

        return $value;
    }
}
