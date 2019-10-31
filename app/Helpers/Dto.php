<?php

namespace App\Helpers;

use ReflectionClass;
use ReflectionProperty;
use ReflectionException;
use InvalidArgumentException;

class Dto
{
    /**
     * @param string $class
     * @param array $attributes
     * @return mixed
     * @throws ReflectionException
     */
    public static function make(string $class, array $attributes = [])
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException('Class for create DTO not found: ' . $class);
        }

        $instance = new $class;

        if (is_array($attributes)) {
            self::loadAttributes($instance, $attributes);
        }

        return $instance;
    }

    /**
     * @param $instance
     * @param array $attributes
     * @throws ReflectionException
     */
    private static function loadAttributes($instance, array $attributes)
    {
        foreach (self::getDtoAttributes($instance) as $key => $value) {
            if ($value === null && !array_key_exists($key, $attributes)) {
                throw new InvalidArgumentException('Wrong data');
            }

            $instance->{$key} = $attributes[$key];
        }
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
        $values = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($values as $property) {
            if (!$property->isStatic()) {
                $attributes[$className][$property->getName()] = $property->getValue($instance);
            }
        }

        return $attributes[$className];
    }
}
