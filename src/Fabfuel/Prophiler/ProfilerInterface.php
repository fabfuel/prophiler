<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 07:52 
 */
namespace Fabfuel\Prophiler;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

interface ProfilerInterface extends \Iterator
{
    /**
     * Start a new benchmark
     *
     * @param string $name Unique identifier like e.g. Class::Method (\Foobar\MyClass::doSomething)
     * @param array $metadata Addtional metadata or data
     * @param string $component Name of the component which triggered the benchmark, e.g. "App", "Database"
     * @return string identifier token
     */
    public function start($name, array $metadata = [], $component = null);

    /**
     * Stop a running benchmark
     * If no token provided, the last started benchmark is stopped
     *
     * @param string $token benchmark identifier
     * @param array $metadata Addtional metadata or data
     * @return BenchmarkInterface
     */
    public function stop($token = null, array $metadata = []);

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
}
