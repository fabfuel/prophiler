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
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon
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

        $eventsManagerDispatcher = $this->getMock('\Phalcon\Events\ManagerInterface');
        $eventsManagerView = $this->getMock('\Phalcon\Events\ManagerInterface');
        $eventsManagerDatabase = $this->getMock('\Phalcon\Events\ManagerInterface');

        $pluginManager->dispatcher->expects($this->any())
            ->method('getEventsManager')
            ->willReturn($eventsManagerDispatcher);

        $pluginManager->view->expects($this->any())
            ->method('getEventsManager')
            ->willReturn($eventsManagerView);

        $pluginManager->db->expects($this->any())
            ->method('getEventsManager')
            ->willReturn($eventsManagerDatabase);

        $eventsManagerDispatcher->expects($this->any())
            ->method('attach')
            ->with('dispatch', $this->isInstanceOf('Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin'));

        $eventsManagerDatabase->expects($this->any())
            ->method('attach')
            ->with('db', $this->isInstanceOf('Fabfuel\Prophiler\Plugin\Phalcon\Db\AdapterPlugin'));

        $eventsManagerView->expects($this->any())
            ->method('attach')
            ->with('view', $this->isInstanceOf('Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin'));


        $pluginManager->register();
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
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::ensureEventsManager
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::__construct
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::setProfiler
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::getProfiler
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
        $this->assertTrue($pluginManager->registerView());
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::registerDatabase
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::ensureEventsManager
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

        $db->expects($this->any())
            ->method('getEventsManager')
            ->willReturn($eventsManager);

        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        DI::setDefault(new FactoryDefault());
        $di = DI::getDefault();
        $di->set('db', $db);
        $di->set('eventsManager', $eventsManager);

        $pluginManager = new Phalcon($profiler);
        $pluginManager->registerDatabase();
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::registerDatabase
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::ensureEventsManager
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     */
    public function testRegisterDatabaseAndSetEventsManager()
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
            ->method('setEventsManager')
            ->with($eventsManager);

        $db->expects($this->at(1))
            ->method('getEventsManager')
            ->willReturn(null);

        $db->expects($this->at(2))
            ->method('getEventsManager')
            ->willReturn($eventsManager);

        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        DI::setDefault(new FactoryDefault());
        $di = DI::getDefault();
        $di->set('db', $db);
        $di->set('eventsManager', $eventsManager);

        $pluginManager = new Phalcon($profiler);
        $pluginManager->registerDatabase();
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::registerDispatcher
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::ensureEventsManager
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     */
    public function testRegisterDispatcherIfNotExisting()
    {
        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        DI::setDefault(new FactoryDefault());
        DI::getDefault()->set('dispatcher', new \stdClass());

        $pluginManager = new Phalcon($profiler);
        $this->assertFalse($pluginManager->registerDispatcher());
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::registerDatabase
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::ensureEventsManager
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::__construct
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::setProfiler
     * @covers Fabfuel\Prophiler\Plugin\Manager\Phalcon::getProfiler
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     */
    public function testRegisterDatabaseIfNotExisting()
    {
        $profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        DI::setDefault(new FactoryDefault());
        DI::getDefault()->set('db', new \stdClass());

        $pluginManager = new Phalcon($profiler);
        $this->assertFalse($pluginManager->registerDatabase());
    }
}
