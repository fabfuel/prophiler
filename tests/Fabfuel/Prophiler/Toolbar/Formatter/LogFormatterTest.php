<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 17.11.14, 08:26
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

class LogFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BenchmarkFormatter|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $formatter;

    /**
     * @var BenchmarkInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $benchmark;

    public function setUp()
    {
        $this->benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->formatter = new LogFormatter();
        $this->formatter->setBenchmark($this->benchmark);
    }

    /**
     * @param string $severity
     * @param string $colorClass
     * @dataProvider getColorClasses
     */
    public function testGetColorClass($severity, $colorClass)
    {
        $this->benchmark->expects($this->any())
            ->method('getMetadata')
            ->willReturn(['severity' => $severity]);

        $this->assertSame($colorClass, $this->formatter->getColorClass());
    }

    /**
     * @return array
     */
    public function getColorClasses()
    {
        return [
            ['A', 'severity-A'],
            ['AB', 'severity-AB'],
            ['ABC', 'severity-ABC'],
        ];
    }

    /**
     * @param string $severity
     * @param string $colorClass
     * @dataProvider getLabels
     */
    public function testGetLabels($severity, $colorClass)
    {
        $this->benchmark->expects($this->any())
            ->method('getMetadata')
            ->willReturn(['severity' => $severity]);

        $this->assertSame($colorClass, $this->formatter->getLabel());
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return [
            ['A', '<span class="label severity-A">A</span>'],
            ['AB', '<span class="label severity-AB">AB</span>'],
            ['ABC', '<span class="label severity-ABC">ABC</span>'],
        ];
    }
}
