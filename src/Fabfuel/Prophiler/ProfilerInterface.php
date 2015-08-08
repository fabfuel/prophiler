<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 07:52 
 */
namespace Fabfuel\Prophiler;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

interface ProfilerInterface extends \Iterator, \Countable
{
    /**
     * Start a new benchmark
     *
     * @param string $name Unique identifier like e.g. Class::Method (\Foobar\MyClass::doSomething)
     * @param array $metadata Additional metadata or data
     * @param string $component Name of the component which triggered the benchmark, e.g. "App", "Database"
     * @return BenchmarkInterface The started benchmark
     */
    public function start($name, array $metadata = [], $component = null);

    /**
     * Stop a running benchmark
     * If no benchmark provided, the last started benchmark is stopped
     *
     * @param BenchmarkInterface $benchmark A previously benchmark
     * @param array $metadata Additional metadata or data
     * @return BenchmarkInterface
     */
    public function stop(BenchmarkInterface $benchmark = null, array $metadata = []);

    /**
     * Get the total number of elapsed time in milliseconds
     *
     * @return double Total number of elapsed milliseconds
     */
    public function getDuration();

    /**
     * Get the start of the profiler in microtime
     *
     * @return double Timestamp in microtime
     */
    public function getStartTime();

    /**
     * Get all aggregators
     *
     * @return AggregatorInterface[]
     */
    public function getAggregators();

    /**
     * Add an aggregator to the profiler
     *
     * @param AggregatorInterface $aggregator
     * @return $this
     */
    public function addAggregator(AggregatorInterface $aggregator);
}
