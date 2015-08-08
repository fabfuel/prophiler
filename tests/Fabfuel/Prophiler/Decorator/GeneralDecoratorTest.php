<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 21.06.15, 09:01 
 */
namespace Fabfuel\Prophiler\Decorator;

use Fabfuel\Prophiler\ProfilerInterface;

class GeneralDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GeneralDecorator
     */
    protected $decorator;

    /**
     * @var Foobar|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $foobar;

    /**
     * @var ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    public function setUp()
    {
        $this->profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');
        $this->foobar = new Foobar();
        $this->decorator = new GeneralDecorator($this->foobar, $this->profiler);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\GeneralDecorator::__construct
     * @covers Fabfuel\Prophiler\Decorator\GeneralDecorator::getProfiler
     * @covers Fabfuel\Prophiler\Decorator\GeneralDecorator::setProfiler
     * @covers Fabfuel\Prophiler\Decorator\GeneralDecorator::getDecorated
     * @covers Fabfuel\Prophiler\Decorator\GeneralDecorator::setDecorated
     */
    public function testConstruct()
    {
        $this->assertSame($this->profiler, $this->decorator->getProfiler());
        $this->assertSame($this->foobar, $this->decorator->getDecorated());
    }

    public function testGetComponentName()
    {
        $expected = 'Fabfuel';
        $this->assertSame($expected, $this->decorator->getComponentName());
    }
}

class Foobar
{
}