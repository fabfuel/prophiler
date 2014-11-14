<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 08:13 
 */
namespace Fabfuel\Prophiler\Benchmark;

/**
 * Interface BenchmarkInterface
 * @package Fabfuel\Prophiler\Benchmark
 */
interface BenchmarkInterface
{
    /**
     * Unique identifier like e.g. Class::Method (\Foobar\MyClass::doSomething)
     *
     * @return string
     */
    public function getName();

    /**
     * Name of the component which triggered the benchmark, e.g. "App", "Database"
     *
     * @return string
     */
    public function getComponent();

    /**
     * Start the benchmark
     *
     * @return void
     */
    public function start();

    /**
     * Stop the benchmark
     *
     * @return void
     */
    public function stop();

    /**
     * Total elapsed microseconds
     *
     * @return string
     */
    public function getDuration();

    /**
     * Custom metadata regarding this benchmark
     *
     * @return array
     */
    public function getMetadata();
}
