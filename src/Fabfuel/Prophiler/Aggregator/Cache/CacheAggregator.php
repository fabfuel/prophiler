<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 22.06.15 08:04
 */

namespace Fabfuel\Prophiler\Aggregator\Cache;

use Fabfuel\Prophiler\Aggregator\AbstractAggregator;
use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

/**
 * Class CacheAggregator
 * @package Fabfuel\Prophiler\Aggregator\Cache
 */
class CacheAggregator extends AbstractAggregator
{
    /**
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public function accept(BenchmarkInterface $benchmark)
    {
        return strpos($benchmark->getComponent(), 'Cache') === 0;
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return string
     */
    public function getCommand(BenchmarkInterface $benchmark)
    {
        return $benchmark->getName();
    }

    /**
     * Get the title of this data collector
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Cache';
    }

    /**
     * Get the font-awesome icon class (e.g. fa-pie-chart)
     * http://fortawesome.github.io/Font-Awesome/icons/
     *
     * @return string
     */
    public function getIcon()
    {
        return '<i class="fa fa-stack-exchange"></i>';
    }
}
