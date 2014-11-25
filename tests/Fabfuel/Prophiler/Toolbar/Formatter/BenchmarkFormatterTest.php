<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 17.11.14, 08:26
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

class BenchmarkFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BenchmarkFormatter
     */
    protected $formatter;

    /**
     * @var BenchmarkInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $benchmark;

    public function setUp()
    {
        $this->benchmark = $this->getBenchmarkMock();

        $this->formatter = new BenchmarkFormatter();
        $this->formatter->setBenchmark($this->benchmark);
    }

    public function testGetId()
    {
        $this->assertSame(spl_object_hash($this->benchmark), $this->formatter->getId());
    }

    public function testIdsAreUnique()
    {
        $lastId = $this->formatter->getId();

        $this->formatter->setBenchmark($this->getBenchmarkMock());
        $this->assertNotSame($lastId, $this->formatter->getId());

        $lastId = $this->formatter->getId();

        $this->formatter->setBenchmark($this->getBenchmarkMock());
        $this->assertNotSame($lastId, $this->formatter->getId());
    }

    public function testGetName()
    {
        $this->benchmark->expects($this->once())
            ->method('getName')
            ->willReturn('Foobar');

        $this->assertSame('Foobar', $this->formatter->getName());
    }

    public function testGetComponent()
    {
        $this->benchmark->expects($this->once())
            ->method('getComponent')
            ->willReturn('Foobar');

        $this->assertSame('Foobar', $this->formatter->getComponent());
    }

    public function testGetMemoryUsage()
    {
        $this->benchmark->expects($this->once())
            ->method('getMemoryUsage')
            ->willReturn(1234567);

        $this->assertSame('1.177 MB', $this->formatter->getMemoryUsage());
    }

    public function testGetDuration()
    {
        $this->benchmark->expects($this->once())
            ->method('getDuration')
            ->willReturn(0.012345);

        $this->assertSame('12.35 ms', $this->formatter->getDuration());
    }

    /**
     * @param string $component
     * @param string $icon
     * @dataProvider getIcons
     */
    public function testGetIcon($component, $icon)
    {
        $this->benchmark->expects($this->once())
            ->method('getComponent')
            ->willReturn($component);

        $this->assertSame($icon, $this->formatter->getIcon());
    }

    /**
     * @param string $component
     * @param string $colorClass
     * @dataProvider getColorClasses
     */
    public function testGetColorClass($component, $colorClass)
    {
        $this->benchmark->expects($this->once())
            ->method('getComponent')
            ->willReturn($component);

        $this->assertSame($colorClass, $this->formatter->getColorClass());
    }

    public function testGetStartTime()
    {
        $time = microtime(true);

        $this->benchmark->expects($this->once())
            ->method('getStartTime')
            ->willReturn($time);

        $this->assertSame($time, $this->formatter->getStartTime());
    }

    public function testGetEndTime()
    {
        $time = microtime(true);

        $this->benchmark->expects($this->once())
            ->method('getEndTime')
            ->willReturn($time);

        $this->assertSame($time, $this->formatter->getEndTime());
    }

    public function testGetMetadata()
    {
        $this->benchmark->expects($this->once())
            ->method('getMetadata')
            ->willReturn(['lorem' => 'ipsum']);

        $this->assertSame(['lorem' => 'ipsum'], $this->formatter->getMetadata());
    }

    /**
     * @return array
     */
    public function getColorClasses()
    {
        return [
            ['A', 'color-1'],
            ['AB', 'color-2'],
            ['ABC', 'color-3'],
            ['ABCD', 'color-4'],
            ['ABCDE', 'color-0'],
        ];
    }

    /**
     * @return array
     */
    public function getIcons()
    {
        return [
            ['MongoDB', 'leaf'],
            ['Foobar', 'cog'],
            ['Lorem Ipsum', 'cog'],
        ];
    }

    /**
     * @return BenchmarkInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getBenchmarkMock()
    {
        return $this->getMockBuilder('Fabfuel\Prophiler\Benchmark\Benchmark')
        ->disableOriginalConstructor()
        ->getMock();
    }
}
