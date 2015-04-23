<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 07:39 
 */
namespace Fabfuel\Prophiler;

use Fabfuel\Prophiler\Benchmark\Benchmark;

class BenchmarkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Benchmark
     */
    protected $benchmark;

    /**
     * @var string $name
     */
    protected $name =  'Foobar';

    /**
     * @var array $metadata
     */
    protected $metadata = ['lorem' => 'ipsum'];

    /**
     * @var string $component
     */
    protected $component = 'Lorem Upsum';

    public function setUp()
    {
        $this->benchmark = new Benchmark($this->name, $this->metadata, $this->component);
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::__construct
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setName
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getName
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getMetadata
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::addMetadata
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getComponent
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setComponent
     */
    public function testConstruct()
    {
        $this->assertSame($this->name, $this->benchmark->getName());
        $this->assertSame($this->metadata, $this->benchmark->getMetadata());
        $this->assertSame($this->component, $this->benchmark->getComponent());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::start
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testStart()
    {
        $this->assertSame(0.0, $this->benchmark->getStartTime());
        $this->assertSame(0.0, $this->benchmark->getMemoryUsageStart());

        $this->benchmark->start();

        $this->assertGreaterThan(0.0, $this->benchmark->getStartTime());
        $this->assertGreaterThan(0.0, $this->benchmark->getMemoryUsageStart());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::stop
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testStop()
    {
        $this->assertSame(0.0, $this->benchmark->getEndTime());
        $this->assertSame(0.0, $this->benchmark->getMemoryUsageEnd());

        $this->benchmark->stop();

        $this->assertGreaterThan(0.0, $this->benchmark->getEndTime());
        $this->assertGreaterThan(0.0, $this->benchmark->getMemoryUsageEnd());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getDuration
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testGetDuration()
    {
        $this->assertSame(0.0, $this->benchmark->getDuration());

        $this->benchmark->start();

        usleep(1);

        $this->assertGreaterThan(0.0, $this->benchmark->getDuration());

        $this->benchmark->stop();

        usleep(1);

        $this->assertGreaterThan(0.0, $this->benchmark->getDuration());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getStartTime
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testGetStartTime()
    {
        $this->assertSame(0.0, $this->benchmark->getStartTime());
        $this->benchmark->start();
        $this->assertGreaterThan(0.0, $this->benchmark->getStartTime());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getEndTime
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testGetEndTime()
    {
        $this->assertSame(0.0, $this->benchmark->getEndTime());
        $this->benchmark->start();

        usleep(1);

        // End usage should be set, even if benchmarked not stopped
        $this->assertGreaterThan(0.0, $this->benchmark->getEndTime());

        $firstEndTime = $this->benchmark->getEndTime();

        usleep(1);

        $this->benchmark->stop();
        $this->assertGreaterThan(0.0, $this->benchmark->getEndTime());
        $this->assertGreaterThan($firstEndTime, $this->benchmark->getEndTime());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getMemoryUsage
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testGetMemoryUsage()
    {
        $this->assertSame(0.0, $this->benchmark->getMemoryUsage());

        $this->benchmark->start();

        $memoryWaste = $this->wasteMemory();

        $this->assertGreaterThan(0.0, $this->benchmark->getMemoryUsage());

        $this->benchmark->stop();
        $this->assertGreaterThan(0.0, $this->benchmark->getMemoryUsage());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getMemoryUsageStart
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testGetMemoryUsageStart()
    {
        $this->assertSame(0.0, $this->benchmark->getMemoryUsageStart());
        $this->benchmark->start();
        $this->assertGreaterThan(0.0, $this->benchmark->getMemoryUsageStart());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getMemoryUsageEnd
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testGetMemoryUsageEnd()
    {
        $this->assertSame(0.0, $this->benchmark->getMemoryUsageEnd());
        $this->benchmark->start();

        $memoryWasteA = $this->wasteMemory();

        // End usage should be set, even if benchmarked not stopped
        $this->assertGreaterThan(0.0, $this->benchmark->getMemoryUsageEnd());

        $firstMemoryUsage = $this->benchmark->getMemoryUsageEnd();

        $memoryWasteB = $this->wasteMemory();

        $this->benchmark->stop();
        $this->assertGreaterThan(0.0, $this->benchmark->getMemoryUsageEnd());
        $this->assertGreaterThan($firstMemoryUsage, $this->benchmark->getMemoryUsageEnd());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getMetadataValue
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testGetMetadataValue()
    {
        $this->assertNull($this->benchmark->getMetadataValue('foobar'));
        $this->assertSame('ipsum', $this->benchmark->getMetadataValue('lorem'));
    }

    protected function wasteMemory()
    {
        $str = 'Lorem ipsum usu amet dicat nullam ea. Nec detracto lucilius democritum in, ne usu delenit offendit deterruisset.
        Recusabo iracundia molestiae ea pro, suas dicta nemore an cum, erat dolorum nonummy mel ea.
        Iisque labores liberavisse in mei, dico laoreet elaboraret nam et, iudico verterem platonem est an.
        Te usu paulo vidisse epicuri, facilis mentitum liberavisse vel ut, movet iriure invidunt ut quo.
        Ad melius mnesarchum scribentur eum, mel at mundi impetus utroque.';

        return (object)explode(' ', $str);
    }
}
