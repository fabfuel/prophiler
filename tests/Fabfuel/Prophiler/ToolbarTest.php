<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 17.11.14 14:37
 */

namespace Fabfuel\Prophiler;

class ToolbarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Fabfuel\Prophiler\Toolbar::__construct
     * @covers Fabfuel\Prophiler\Toolbar::setProfiler
     * @covers Fabfuel\Prophiler\Toolbar::getProfiler
     */
    public function testGetAndSetProfiler()
    {
        $profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $toolbar = new Toolbar($profiler);

        $this->assertSame($profiler, $toolbar->getProfiler());
    }

    /**
     * @covers Fabfuel\Prophiler\Toolbar::__construct
     * @covers Fabfuel\Prophiler\Toolbar::render
     * @uses Fabfuel\Prophiler\Toolbar
     */
    public function testRender()
    {
        $profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $profiler->expects($this->once())
            ->method('getBenchmarks')
            ->willReturn([]);

        $toolbar = new Toolbar($profiler);

        $dispatcher = $this->getMockBuilder('Phalcon\Mvc\Dispatcher')->getMock();
        $toolbar->dispatcher = $dispatcher;

        ob_start();
        $toolbar->render();
        $output = ob_get_clean();

        $this->assertNotEmpty($output);
    }

    /**
     * @covers Fabfuel\Prophiler\Toolbar::addDataCollector
     * @covers Fabfuel\Prophiler\Toolbar::getDataCollectors
     * @uses Fabfuel\Prophiler\Toolbar
     */
    public function testAddAndGetDataCollectors()
    {
        $profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $toolbar = new Toolbar($profiler);

        $this->assertCount(0, $toolbar->getDataCollectors());

        $dataCollector = $this->getMock('Fabfuel\Prophiler\DataCollector\Request');
        $toolbar->addDataCollector($dataCollector);

        $this->assertCount(1, $toolbar->getDataCollectors());
        $this->assertSame($dataCollector, $toolbar->getDataCollectors()[0]);
    }
}
