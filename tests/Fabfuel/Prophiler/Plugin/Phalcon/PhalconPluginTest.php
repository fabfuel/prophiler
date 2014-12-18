<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 18.11.14, 08:06 
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon;

use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\DI\FactoryDefault;
use Phalcon\DI\InjectionAwareInterface;
use Phalcon\DiInterface;

abstract class PhalconPluginTest extends \PHPUnit_Framework_TestCase
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
        if(!extension_loaded('phalcon')) {
            $this->markTestSkipped('Phalcon extension isn\'t installed');
            return;
        }

        $this->setDI(new FactoryDefault());
        $this->setProfiler($this->getMock('Fabfuel\Prophiler\Profiler'));
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
