<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 14.11.14 12:13
 */

namespace Fabfuel\Prophiler\Plugin\Phalcon\Db;

use Fabfuel\Prophiler\Plugin\Phalcon\PhalconPluginTest;

class AdapterPluginTest extends PhalconPluginTest
{
    /**
     * @var AdapterPlugin
     */
    protected $adapterPlugin;

    public function setUp()
    {
        parent::setUp();
        $this->adapterPlugin = AdapterPlugin::getInstance($this->profiler, $this->dependencyInjector) ;
    }

    public function testQuery()
    {
        $token = 'token';

        $adapter = $this->getMockBuilder('Phalcon\Db\Adapter')
            ->disableOriginalConstructor()
            ->getMock();

        $adapter->expects($this->once())
            ->method('getSQLStatement')
            ->willReturn('SELECT * FROM foobar;');

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->exactly(1))
            ->method('getSource')
            ->willReturn($adapter);

        $metadata = [
            'query' => 'SELECT * FROM foobar;'
        ];

        $this->profiler->expects($this->once())
            ->method('start')
            ->with(get_class($adapter) . '::query', $metadata, 'Database')
            ->willReturn($token);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($token);

        $this->adapterPlugin->beforeQuery($event, $adapter);
        $this->adapterPlugin->afterQuery($event, $adapter);
    }
}
