<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 17:28 
 */
namespace Fabfuel\Prophiler\Benchmark;

class BenchmarkFactoryTest extends \PHPUnit_Framework_TestCase 
{
    public function testGetBenchmark()
    {
        $name = 'Foobnar';
        $metadata = ['lorem' => 'ipsum'];

        $benchmark = BenchmarkFactory::getBenchmark($name, $metadata);

        $this->assertInstanceOf('Fabfuel\Prophiler\Benchmark\Benchmark', $benchmark);
        $this->assertSame($name, $benchmark->getName());
        $this->assertSame($metadata, $benchmark->getMetadata());
    }
}
