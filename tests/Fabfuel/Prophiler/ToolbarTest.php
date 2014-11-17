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
     * @covers Fabfuel\Prophiler\Toolbar::register
     * @covers Fabfuel\Prophiler\Toolbar::__construct
     * @covers Fabfuel\Prophiler\Toolbar::setProfiler
     * @covers Fabfuel\Prophiler\Toolbar::getProfiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     */
    public function testRegister()
    {
        $profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $eventsManager = $this->getMockBuilder('Phalcon\Events\Manager')
            ->getMock();

        $eventsManager->expects($this->exactly(3))
            ->method('attach');

        $toolbar = new Toolbar($profiler);
        $toolbar->setEventsManager($eventsManager);

        $dispatcher = $this->getMockBuilder('Phalcon\Mvc\Dispatcher')->getMock();
        $toolbar->dispatcher = $dispatcher;

        $this->assertSame($toolbar, $toolbar->register());
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
