<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 14.11.14 12:13
 */

namespace Fabfuel\Prophiler\Plugin\Phalcon\Db;

use Fabfuel\Prophiler\Profiler;
use Phalcon\DI;

class AdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var View
     */
    protected $adapter;

    /**
     * @var Profiler|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    public function setUp()
    {
        DI::setDefault(new DI\FactoryDefault());

        $this->adapter = new Adapter();

        $this->profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')->getMock();
        DI::getDefault()->set('profiler', $this->profiler, true);
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

        $this->adapter->beforeQuery($event, $adapter);
        $this->adapter->afterQuery($event, $adapter);
    }
}
