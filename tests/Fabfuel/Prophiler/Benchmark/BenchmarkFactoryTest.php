<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 17:28 
 */
namespace Fabfuel\Prophiler\Benchmark;

class BenchmarkFactoryTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @covers Fabfuel\Prophiler\Benchmark\BenchmarkFactory::getBenchmark
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testGetBenchmark()
    {
        $name = 'Foobar';
        $component = 'Lorem Ipsum';
        $metadata = ['lorem' => 'ipsum'];

        $benchmark = BenchmarkFactory::getBenchmark($name, $metadata, $component);

        $this->assertInstanceOf('Fabfuel\Prophiler\Benchmark\BenchmarkInterface', $benchmark);
        $this->assertSame($name, $benchmark->getName());
        $this->assertSame($metadata, $benchmark->getMetadata());
        $this->assertSame($component, $benchmark->getComponent());
    }
}
