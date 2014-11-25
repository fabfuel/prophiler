<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 17:26 
 */
namespace Fabfuel\Prophiler\Benchmark;

class BenchmarkFactory
{
    /**
     * @param string $name Unique identifier like e.g. Class::Method (\Foobar\MyClass::doSomething)
     * @param array $metadata Additional metadata
     * @param string $component Name of the component which triggered the benchmark, e.g. "App", "Database"
     * @return BenchmarkInterface
     */
    public static function getBenchmark($name, $metadata = [], $component = null)
    {
        return new Benchmark($name, $metadata, $component);
    }
}
