<?php

namespace App\Entity;

use \InvalidArgumentException;
use \ReflectionClass;

class AbstractEntity
{
    public function __get($name): mixed
    {
        if ($this->isDefinedProperty($name)) {
            return $this->$name;
        }
    }
    
    public function __set(string $name, mixed $value): void
    {
        if ($this->isDefinedProperty($name)) {
            $this->$name = $name;
        }
    }
    
    public function __call(string $name, array $arguments): mixed
    {
        if ($this->isDefinedProperty($name) && empty($arguments)) {
            return $this->$name;
        }
        if ($this->isDefinedProperty($name) && isset($arguments[0])) {
            $this->$name = $arguments[0];
        }
    }
    
    private function isDefinedProperty($name): bool
    {
        $reflection = new ReflectionClass($this);
        if (!$reflection->hasProperty($name)) {
            throw new InvalidArgumentException("Unknown property '$name' in class " . get_class($this));
        }
        return true;
    }
}