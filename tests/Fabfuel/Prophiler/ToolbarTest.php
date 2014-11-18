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
}
