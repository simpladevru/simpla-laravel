<?php

namespace App\Helpers;

use ReflectionClass;
use ReflectionException;

class DtoHelper
{
    /**
     * @param array $data
     * @param string $class
     * @return mixed
     * @throws ReflectionException
     */
    public static function arrayToDto(array $data, string $class)
    {
        $instance = new $class;

        foreach (self::getDtoAttributes($instance) as $key => $value) {
            $instance->{$key} = $data[$key];
        }

        return $instance;
    }

    /**
     * @param $instance
     * @return array
     * @throws ReflectionException
     */
    private static function getDtoAttributes($instance): array
    {
        static $attributes = [];

        $className = get_class($instance);

        if (!empty($attributes[$className])) {
            return $attributes[$className];
        }

        $class  = new ReflectionClass($instance);
        $values = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($values as $property) {
            if (!$property->isStatic()) {
                $attributes[$className][$property->getName()] = $property->getValue($instance);
            }
        }

        return $attributes[$className];
    }
}
