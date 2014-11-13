<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 17:26 
 */
namespace Fabfuel\Prophiler\Benchmark;

class BenchmarkFactory
{
    /**
     * @param string $name
     * @param array $metadata
     * @return BenchmarkInterface
     */
    public static function getBenchmark($name, $metadata = [])
    {
        return new Benchmark($name, $metadata);
    }
}
