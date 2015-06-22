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
    protected function setUp()
    {
        parent::setUp();
        if(!extension_loaded('phalcon')) {
            $this->markTestSkipped('Phalcon extension isn\'t installed');
            return;
        }
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::register
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::__construct
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::getProfiler
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::setProfiler
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::setDI
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::getDI
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     */
    public function testRegister()
    {
        DI::setDefault(new FactoryDefault());

        $profiler = $this->getMock('Fabfuel\Prophiler\Profiler');

        $pluginManager = new Phalcon($profiler);
        $pluginManager->dispatcher = $this->getMock('Phalcon\Mvc\Dispatcher');
        $pluginManager->view = $this->getMock('Phalcon\Mvc\View');
        $pluginManager->db = $this->getMockBuilder('Phalcon\Db\Adapter\Pdo')->disableOriginalConstructor()->getMock();

        $pluginManager->register();

        $this->assertTrue($pluginManager->eventsManager->hasListeners('dispatch'));
        $this->assertTrue($pluginManager->eventsManager->hasListeners('view'));
        $this->assertTrue($pluginManager->eventsManager->hasListeners('db'));
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::registerDispatcher
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     */
    public function testRegisterDispatcher()
    {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        $eventsManager = $this->getMock('\Phalcon\Events\ManagerInterface');
        $eventsManager->expects($this->once())
            ->method('attach')
            ->with('dispatch', $this->isInstanceOf('Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin'));

        DI::setDefault(new FactoryDefault());
        $di = DI::getDefault();
        $di->set('dispatcher', $dispatcher);
        $di->set('eventsManager', $eventsManager);

        $pluginManager = new Phalcon($profiler);

        $this->assertNull($dispatcher->getEventsManager());
        $pluginManager->registerDispatcher();
        $this->assertSame($eventsManager, $dispatcher->getEventsManager());
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::registerView
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     */
    public function testRegisterView()
    {
        $view = new \Phalcon\Mvc\View();
        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        $eventsManager = $this->getMock('\Phalcon\Events\ManagerInterface');
        $eventsManager->expects($this->once())
            ->method('attach')
            ->with('view', $this->isInstanceOf('Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin'));

        DI::setDefault(new FactoryDefault());
        $di = DI::getDefault();
        $di->set('view', $view);
        $di->set('eventsManager', $eventsManager);

        $pluginManager = new Phalcon($profiler);

        $this->assertNull($view->getEventsManager());
        $pluginManager->registerView();
        $this->assertSame($eventsManager, $view->getEventsManager());
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::registerDatabase
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     */
    public function testRegisterDatabase()
    {
        $eventsManager = $this->getMock('\Phalcon\Events\ManagerInterface');
        $eventsManager->expects($this->once())
            ->method('attach')
            ->with('db', $this->isInstanceOf('Fabfuel\Prophiler\Plugin\Phalcon\Db\AdapterPlugin'));

        $db = $this->getMockBuilder('Phalcon\Db\Adapter\Pdo')
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();

        $db->expects($this->once())
            ->method('getEventsManager')
            ->willReturn(null);

        $db->expects($this->once())
            ->method('setEventsManager')
            ->with($eventsManager);

        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        DI::setDefault(new FactoryDefault());
        $di = DI::getDefault();
        $di->set('db', $db);
        $di->set('eventsManager', $eventsManager);

        $pluginManager = new Phalcon($profiler);
        $pluginManager->registerDatabase();
    }
}
