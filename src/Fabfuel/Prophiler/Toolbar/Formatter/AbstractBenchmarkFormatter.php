<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 22.11.14, 08:20 
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

class AbstractBenchmarkFormatter
{
    /**
     * Available bootstrap label classes
     *
     * @var array
     */
    protected $colors = [
        '#337ab7',
        '#d9534f',
        '#5cb85c',
        '#f0ad4e',
        '#5bc0de',
    ];

    /**
     * @var BenchmarkInterface
     */
    protected $benchmark;

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

    /**
     * @return string
     */
    public function getId()
    {
        return spl_object_hash($this->getBenchmark());
    }

    public function getColor()
    {
        $colorIndex = strlen($this->getComponent()) % count($this->colors);
        return $this->colors[$colorIndex];
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
     * @return array
     */
    public function getMetadata()
    {
        return $this->getBenchmark()->getMetadata();
    }
}
