<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 23.04.15 17:53
 */

namespace Fabfuel\Prophiler\Aggregator;

use Fabfuel\Prophiler\AggregatorInterface;
use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

abstract class AbstractAggregator implements AggregatorInterface
{
    /**
     * @var AggregationInterface
     */
    private $total;

    /**
     * @var AggregationInterface[]
     */
    private $aggregations = [];

    /**
     * @var int
     */
    protected $countWarning = 10;

    /**
     * @var int
     */
    protected $countCritical = 20;

    /**
     * @var int
     */
    protected $durationWarning = 10;

    /**
     * @var int
     */
    protected $durationCritical = 20;

    /**
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public abstract function accept(BenchmarkInterface $benchmark);

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
            $this->total = new Aggregation();
        }

        return $this->total;
    }

    /**
     * @return string
     */
    public function getSeverity()
    {
        if ($this->count() === 0) {
            return 'info';
        } elseif ($this->count() >= $this->getCountCritical() || $this->getTotal()->getMaxDuration() * 1000 > $this->getDurationCritical()) {
            return 'critical';
        } elseif ($this->count() >= $this->getCountWarning() || $this->getTotal()->getMaxDuration() * 1000 > $this->getDurationWarning()) {
            return 'warning';
        }
        return 'debug';
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
