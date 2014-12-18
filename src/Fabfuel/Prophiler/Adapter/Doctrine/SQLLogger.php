<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 17.12.14 17:11
 */

namespace Fabfuel\Prophiler\Adapter\Doctrine;

use Doctrine\DBAL\Logging\SQLLogger as DoctrineSQLLogger;
use Fabfuel\Prophiler\Adapter\AdapterAbstract;
use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

class SQLLogger extends AdapterAbstract implements DoctrineSQLLogger
{
    /**
     * @var BenchmarkInterface
     */
    protected $currentBenchmark;

    /**
     * Logs a SQL statement
     *
     * @param string $sql The SQL to be executed
     * @param array|null $params The SQL parameters
     * @param array|null $types The SQL parameter types
     * @return void
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $metadata = [
            'query' => $sql,
            'params' => $params,
            'types' => $types,
        ];
        $this->setCurrentBenchmark($this->profiler->start('Doctrine::query', $metadata, 'Database'));
    }

    /**
     * Marks the last started query as stopped
     *
     * @return void
     */
    public function stopQuery()
    {
        $this->profiler->stop($this->getCurrentBenchmark());
    }

    /**
     * @return BenchmarkInterface
     */
    public function getCurrentBenchmark()
    {
        return $this->currentBenchmark;
    }

    /**
     * @param BenchmarkInterface $currentBenchmark
     */
    public function setCurrentBenchmark(BenchmarkInterface $currentBenchmark)
    {
        $this->currentBenchmark = $currentBenchmark;
    }
}
