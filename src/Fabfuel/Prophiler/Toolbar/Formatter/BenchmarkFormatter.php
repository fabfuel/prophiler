<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 17.11.14, 07:45 
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

class BenchmarkFormatter implements BenchmarkFormatterInterface
{
    /**
     * @var BenchmarkInterface
     */
    protected $benchmark;

    /**
     * @return string
     */
    public function getId()
    {
        return spl_object_hash($this->getBenchmark());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBenchmark()->getName();
    }

    /**
     * @return string
     */
    public function getComponent()
    {
        return $this->getBenchmark()->getComponent();
    }

    /**
     * @return string
     */
    public function getMemoryUsage()
    {
        return sprintf('%05.2f MB', ($this->getBenchmark()->getMemoryUsage() /1024 /1024 ));
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        return sprintf('%05.2f ms', ($this->getBenchmark()->getDuration() * 1000));
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        switch ($this->getBenchmark()->getComponent()) {
            case 'MongoDB':
                return 'success';
            default:
                return 'primary';
        }
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        switch ($this->getBenchmark()->getComponent()) {
            case 'MongoDB':
                return 'leaf';
            default:
                return 'cog';
        }
    }

    /**
     * @return double
     */
    public function getStartTime()
    {
        return $this->getBenchmark()->getStartTime();
    }

    /**
     * @return double
     */
    public function getEndTime()
    {
        return $this->getBenchmark()->getEndTime();
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->getBenchmark()->getMetadata();
    }

    /**
     * @return BenchmarkInterface
     */
    public function getBenchmark()
    {
        return $this->benchmark;
    }

    /**
     * @param BenchmarkInterface $benchmark
     */
    public function setBenchmark(BenchmarkInterface $benchmark)
    {
        $this->benchmark = $benchmark;
    }
}
