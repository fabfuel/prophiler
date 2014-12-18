<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 14.11.14 12:08
 */

namespace Fabfuel\Prophiler\Adapter\Fabfuel;

class MongoTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        if(!interface_exists('\Mongo\Profiler\ProfilerInterface')) {
            $this->markTestSkipped('fabfuel/mongo package isn\'t installed');
            return;
        }
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Fabfuel\Mongo::__construct
     * @covers Fabfuel\Prophiler\Adapter\Fabfuel\Mongo::start
     * @covers Fabfuel\Prophiler\Adapter\Fabfuel\Mongo::stop
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testConstruct()
    {
        $name = 'foobar';
        $metadata = ['lorem' => 'ipsum'];
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $identifier = spl_object_hash($benchmark);

        $profiler = $this->getMock('Fabfuel\Prophiler\Profiler');

        $profiler->expects($this->once())
            ->method('start')
            ->with($name, $metadata, 'MongoDB')
            ->will($this->returnValue($benchmark));

        $profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $adapter = new Mongo($profiler);

        $benchmarkIdentifier = $adapter->start($name, $metadata);
        $this->assertSame($benchmarkIdentifier, $identifier);

        $adapter->stop($identifier);
    }
}
