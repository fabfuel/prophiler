<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 18.11.14, 08:06 
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon;

use Fabfuel\Prophiler\Profiler;
use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\DI\FactoryDefault;
use Phalcon\DI\InjectionAwareInterface;
use Phalcon\DiInterface;

abstract class PhalconPluginTest extends \PHPUnit_Framework_TestCase implements InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $dependencyInjector;

    /**
     * @var ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    public function setUp()
    {
        $this->setDI(new FactoryDefault());
        $this->setProfiler($this->getMockBuilder('Fabfuel\Prophiler\Profiler')->getMock());
    }

    /**
     * @return ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * @param ProfilerInterface $profiler
     */
    public function setProfiler($profiler)
    {
        $this->profiler = $profiler;
    }
    /**
     * @return DiInterface
     */
    public function getDI()
    {
        return $this->dependencyInjector;
    }

    /**
     * @param DiInterface $dependencyInjector
     */
    public function setDI($dependencyInjector)
    {
        $this->dependencyInjector = $dependencyInjector;
    }
}
