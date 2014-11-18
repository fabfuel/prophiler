<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 18.11.14, 08:29 
 */
namespace Fabfuel\Prophiler\Plugin\Manager;

use Phalcon\DI;
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
     */
    public function testRegister()
    {
        DI::setDefault(new FactoryDefault());

        $profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $pluginManager = new Phalcon($profiler);

        $dispatcher = $this->getMockBuilder('Phalcon\Mvc\Dispatcher')->getMock();
        $pluginManager->dispatcher = $dispatcher;

        $this->assertFalse($pluginManager->eventsManager->hasListeners('dispatch'));
        $this->assertFalse($pluginManager->eventsManager->hasListeners('view'));
        $this->assertFalse($pluginManager->eventsManager->hasListeners('db'));

        $pluginManager->register();

        $this->assertTrue($pluginManager->eventsManager->hasListeners('dispatch'));
        $this->assertTrue($pluginManager->eventsManager->hasListeners('view'));
        $this->assertTrue($pluginManager->eventsManager->hasListeners('db'));
    }
}
