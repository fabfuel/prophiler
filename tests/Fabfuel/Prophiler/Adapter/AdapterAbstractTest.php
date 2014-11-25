<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 14.11.14 12:01
 */

namespace Fabfuel\Prophiler\Adapter;

class AdapterAbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Fabfuel\Prophiler\Adapter\AdapterAbstract::__construct
     * @covers Fabfuel\Prophiler\Adapter\AdapterAbstract::getProfiler
     * @covers Fabfuel\Prophiler\Adapter\AdapterAbstract::setProfiler
     */
    public function testConstruct()
    {
        $profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $adapter = $this->getMockBuilder('Fabfuel\Prophiler\Adapter\AdapterAbstract')
            ->setConstructorArgs([$profiler])
            ->getMockForAbstractClass();

        $this->assertSame($profiler, $adapter->getProfiler());
    }
}
