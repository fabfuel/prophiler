<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 18.11.14, 08:29 
 */
namespace Fabfuel\Prophiler\Plugin\Manager;

use Phalcon\DI\FactoryDefault;

class PhalconTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::register
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::__construct
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::getProfiler
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::setProfiler
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::setDI
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::getDI
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\PhalconPluginAbstract
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

        $di = new FactoryDefault();
        $di->set('eventsManager', $eventsManager);

        $pluginManager = new Phalcon($profiler, $di);

        $dispatcher = $this->getMockBuilder('Phalcon\Mvc\Dispatcher')->getMock();
        $pluginManager->dispatcher = $dispatcher;

        $pluginManager->register();
    }
}
