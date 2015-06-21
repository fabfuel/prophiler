<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 23.04.15 17:47
 */

namespace Fabfuel\Prophiler\Aggregator\Database;

use Fabfuel\Prophiler\Aggregator\AbstractAggregator;
use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

/**
 * Class QueryAggregator
 * @package Fabfuel\Prophiler\Aggregator\Database
 */
class QueryAggregator extends AbstractAggregator
{
    /**
     * @param BenchmarkInterface $benchmark
     * @return bool
     */
    public function accept(BenchmarkInterface $benchmark)
    {
        return $benchmark->getComponent() === 'Database';
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @return string
     */
    public function getCommand(BenchmarkInterface $benchmark)
    {
        return $benchmark->getMetadataValue('query') ?: $benchmark->getName();
    }

    /**
     * Get the title of this data collector
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Queries';
    }

    /**
     * Get the font-awesome icon class (e.g. fa-pie-chart)
     * http://fortawesome.github.io/Font-Awesome/icons/
     *
     * @return string
     */
    public function getIcon()
    {
        return '<i class="fa fa-database"></i>';
    }
}
