<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 23.04.15 07:53
 */

namespace Fabfuel\Prophiler\Aggregator;

use Fabfuel\Prophiler\Adapter\Psr\Log\Logger;
use Fabfuel\Prophiler\AggregatorInterface;
use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

abstract class AbstractAggregator implements AggregatorInterface
{
    /**
     * @var AggregationInterface
     */
    protected $total;

    /**
     * @var AggregationInterface[]
     */
    protected $aggregations = [];

    /**
     * Number of executions per command, which should mark the aggregation as warning
     *
     * @var int
     */
    protected $countWarning = 10;

    /**
     * Number of executions per command, which should mark the aggregation as critical
     *
     * @var int
     */
    protected $countCritical = 20;

    /**
     * Duration threshold (in ms), which should mark the aggregation as warning
     *
     * @var int
     */
    protected $durationWarning = 10;

    /**
     * Duration threshold (in ms), which should mark the aggregation as critical
     *
     * @var int
     */
    protected $durationCritical = 20;

    /**
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public abstract function accept(BenchmarkInterface $benchmark);

    /**
     * @param BenchmarkInterface $benchmark
     * @return string
     */
    public abstract function getCommand(BenchmarkInterface $benchmark);

    /**
     * Add Benchmark to aggregator
     *
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public function aggregate(BenchmarkInterface $benchmark)
    {
        if (!$this->accept($benchmark)) {
            return false;
        }

        $this->getTotal()->aggregate($benchmark);
        $this->getAggregation($this->getCommand($benchmark))->aggregate($benchmark);

        return true;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->getTotal()->getTotalExecutions();
    }

    /**
     * @return AggregationInterface[]
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param string $command
     * @return AggregationInterface
     */
    public function getAggregation($command)
    {
        if (!isset($this->aggregations[$command])) {
            $this->aggregations[$command] = new Aggregation($command);
        }

        return $this->aggregations[$command];
    }

    /**
     * @return AggregationInterface
     */
    public function getTotal()
    {
        if ($this->total === null) {
            $this->total = new Aggregation('total');
        }

        return $this->total;
    }

    /**
     * @return string
     */
    public function getSeverity()
    {
        if ($this->count() === 0) {
            return Logger::SEVERITY_INFO;
        } elseif ($this->isCritical()) {
            return Logger::SEVERITY_CRITICAL;
        } elseif ($this->isWarning()) {
            return Logger::SEVERITY_WARNING;
        }
        return Logger::SEVERITY_DEBUG;
    }

    /**
     * @return bool
     */
    public function isCritical()
    {
        return $this->count() >= $this->getCountCritical()
            || $this->getTotal()->getMaxDuration() > $this->getDurationCritical();
    }

    /**
     * @return bool
     */
    public function isWarning()
    {
        return $this->count() >= $this->getCountWarning()
            || $this->getTotal()->getMaxDuration() > $this->getDurationWarning();
    }

    /**
     * @return int
     */
    public function getCountWarning()
    {
        return $this->countWarning;
    }

    /**
     * @return int
     */
    public function getCountCritical()
    {
        return $this->countCritical;
    }

    /**
     * @return int
     */
    public function getDurationWarning()
    {
        return $this->durationWarning;
    }

    /**
     * @return int
     */
    public function getDurationCritical()
    {
        return $this->durationCritical;
    }
}
