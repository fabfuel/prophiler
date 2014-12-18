<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 18.12.14 11:21
 */

namespace Fabfuel\Prophiler\Adapter\Doctrine;

class SQLLoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Fabfuel\Prophiler\Adapter\Doctrine\SQLLogger::startQuery
     * @uses Fabfuel\Prophiler\Adapter\Doctrine\SQLLogger
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testStart()
    {
        $name = 'Doctrine::query';
        $sql = 'SELECT * FROM foobar;';
        $params = ['lorem' => 'ipsum'];
        $types = ['foo' => 'bar'];
        $metadata = [
            'query' => $sql,
            'params' => $params,
            'types' => $types,
        ];

        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        $profiler->expects($this->once())
            ->method('start')
            ->with($name, $metadata, 'Database')
            ->will($this->returnValue($benchmark));

        $adapter = new SQLLogger($profiler);
        $adapter->startQuery($sql, $params, $types);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Doctrine\SQLLogger::stopQuery
     * @uses Fabfuel\Prophiler\Adapter\Doctrine\SQLLogger
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testStop()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        $profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $adapter = new SQLLogger($profiler);
        $adapter->setCurrentBenchmark($benchmark);
        $adapter->stopQuery($benchmark);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Doctrine\SQLLogger::getCurrentBenchmark
     * @covers Fabfuel\Prophiler\Adapter\Doctrine\SQLLogger::setCurrentBenchmark
     * @uses Fabfuel\Prophiler\Adapter\Doctrine\SQLLogger
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testSetAndGetCurrentBenchmark()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $profiler = $this->getMock('Fabfuel\Prophiler\Profiler');

        $adapter = new SQLLogger($profiler);

        $this->assertNull($adapter->getCurrentBenchmark());

        $adapter->setCurrentBenchmark($benchmark);
        $this->assertSame($benchmark, $adapter->getCurrentBenchmark());
    }
}
