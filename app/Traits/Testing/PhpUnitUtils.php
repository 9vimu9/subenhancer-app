<?php

declare(strict_types=1);

namespace App\Traits\Testing;

use ReflectionClass;

trait PhpUnitUtils
{
    public function callMethod($obj, $name, array $args = [])
    {
        $class = new ReflectionClass($obj);

        return $class->getMethod($name)->invokeArgs($obj, $args);
    }
}
