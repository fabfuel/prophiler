<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 21.06.15 15:39
 */

namespace Fabfuel\Prophiler\Aggregator;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

class Aggregation implements AggregationInterface
{
    /**
     * @var string
     */
    private $command = '';

    /**
     * @var int
     */
    private $totalExecutions = 0;

    /**
     * @var float
     */
    private $totalDuration = 0.0;

    /**
     * @var float
     */
    private $minDuration = 0.0;

    /**
     * @var float
     */
    private $maxDuration = 0.0;

    /**
     * @var float
     */
    private $avgDuration = 0.0;

    /**
     * @var array
     */
    private $benchmarks = [];

    /**
     * @param string $command
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * @param BenchmarkInterface $benchmark
     */
    public function aggregate(BenchmarkInterface $benchmark)
    {
        $this->totalExecutions += 1;
        $this->totalDuration += (float) $benchmark->getDuration();

        $this->avgDuration = (float) $this->totalDuration / $this->totalExecutions;

        if ($benchmark->getDuration() > $this->maxDuration) {
            $this->maxDuration = (float) $benchmark->getDuration();
        }

        if ($benchmark->getDuration() < $this->minDuration || !$this->minDuration) {
            $this->minDuration = (float) $benchmark->getDuration();
        }

        $this->benchmarks[] = $benchmark;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return BenchmarkInterface[]
     */
    public function getBenchmarks()
    {
        return $this->benchmarks;
    }

    /**
     * @return int
     */
    public function getTotalExecutions()
    {
        return $this->totalExecutions;
    }

    /**
     * @return float
     */
    public function getTotalDuration()
    {
        return $this->totalDuration;
    }

    /**
     * @return float
     */
    public function getAvgDuration()
    {
        return $this->avgDuration;
    }

    /**
     * @return float
     */
    public function getMinDuration()
    {
        return $this->minDuration;
    }

    /**
     * @return float
     */
    public function getMaxDuration()
    {
        return $this->maxDuration;
    }
}
