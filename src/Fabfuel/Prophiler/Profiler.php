<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 07:47 
 */
namespace Fabfuel\Prophiler;

use Fabfuel\Prophiler\Benchmark\BenchmarkFactory;
use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;
use Fabfuel\Prophiler\Exception\UnknownBenchmarkException;

class Profiler implements ProfilerInterface, \Countable
{
    /**
     * @var BenchmarkInterface[]
     */
    protected $benchmarks = [];

    /**
     * @var double Starting time
     */
    protected $start;

    /**
     * Save start time on construction
     */
    public function __construct()
    {
        $this->start = (double)microtime(true);
    }

    /**
     * Start a new benchmark
     *
     * @param string $name Unique identifier like e.g. Class::Method (\Foobar\MyClass::doSomething)
     * @param array $metadata Additional metadata
     * @param string $component Name of the component which triggered the benchmark, e.g. "App", "Database"
     * @return string Benchmark identifier token
     */
    public function start($name, array $metadata = [], $component = null)
    {
        $benchmark = BenchmarkFactory::getBenchmark($name, $metadata, $component);
        $benchmark->start();
        return $this->addBenchmark($benchmark);
    }

    /**
     * Stop a running benchmark
     *
     * @param string $token Benchmark identifier
     * @throws UnknownBenchmarkException
     */
    public function stop($token)
    {
        if (!isset($this->benchmarks[$token])) {
            throw new UnknownBenchmarkException('Undefined benchmark: ' . $token);
        }
        $this->benchmarks[$token]->stop();
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return string
     */
    public function addBenchmark(BenchmarkInterface $benchmark)
    {
        $token = spl_object_hash($benchmark);
        $this->benchmarks[$token] = $benchmark;
        return $token;
    }

    /**
     * Get the total number of benchmarks
     *
     * @return int Total number of benchmarks
     */
    public function count()
    {
        return count($this->benchmarks);
    }

    /**
     * Get the total number of elapsed time in milliseconds
     *
     * @return double Total number of elapsed milliseconds
     */
    public function getDuration()
    {
        return (microtime(true) - $this->start);
    }

    /**
     * Return all measured benchmarks
     *
     * @return BenchmarkInterface[]
     */
    public function getBenchmarks()
    {
        return $this->benchmarks;
    }
}
