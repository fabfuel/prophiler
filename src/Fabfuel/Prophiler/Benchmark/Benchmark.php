<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 08:11 
 */
namespace Fabfuel\Prophiler\Benchmark;

/**
 * Class Benchmark
 * @package Fabfuel\Prophiler\Benchmark
 */
class Benchmark implements BenchmarkInterface
{
    /**
     * @var string Unique identifier
     */
    protected $name;

    /**
     * @var double Starting time
     */
    protected $start = 0;

    /**
     * @var double Ending time
     */
    protected $end = 0;

    /**
     * @var array Custom metadata regarding this benchmark
     */
    protected $metadata = [];

    /**
     * @param string $name
     * @param array $options
     */
    public function __construct($name, array $options = null)
    {
        $this->setName($name);
        $this->setMetadata($options);
    }

    /**
     * Start the benchmark
     *
     * @return void
     */
    public function start()
    {
        $this->start = microtime(true);
    }

    /**
     * Stop the benchmark
     *
     * @return void
     */
    public function stop()
    {
        $this->end = microtime(true);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return double Timestamp in microtime
     */
    public function getDuration()
    {
        return $this->getEnd() - $this->getStart();
    }

    /**
     * @return double Timestamp in microtime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return double Timestamp in microtime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $options
     */
    public function setMetadata($options)
    {
        $this->metadata = $options;
    }
}
