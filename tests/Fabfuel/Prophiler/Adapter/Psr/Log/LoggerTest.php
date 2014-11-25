<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 25.11.14, 07:33 
 */
namespace Fabfuel\Prophiler\Adapter\Psr\Log;

use Fabfuel\Prophiler\ProfilerInterface;

class LoggerTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @var Logger
     */
    protected $logger;


    /**
     * @var ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    public function setUp()
    {
        $this->profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $this->profiler->expects($this->once())
            ->method('stop');

        $this->logger = new Logger($this->profiler);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::emergency
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::log
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testEmergeny()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Lorem Ipsum', ['foo' => 'bar', 'severity' => 'emergency'], 'Logger');

        $this->logger->emergency('Lorem Ipsum', ['foo' => 'bar']);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::alert
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::log
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testAlert()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Lorem Ipsum', ['foo' => 'bar', 'severity' => 'alert'], 'Logger');

        $this->logger->alert('Lorem Ipsum', ['foo' => 'bar']);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::critical
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::log
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testCritical()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Lorem Ipsum', ['foo' => 'bar', 'severity' => 'critical'], 'Logger');

        $this->logger->critical('Lorem Ipsum', ['foo' => 'bar']);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::error
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::log
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testError()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Lorem Ipsum', ['foo' => 'bar', 'severity' => 'error'], 'Logger');

        $this->logger->error('Lorem Ipsum', ['foo' => 'bar']);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::warning
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::log
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testWarning()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Lorem Ipsum', ['foo' => 'bar', 'severity' => 'warning'], 'Logger');

        $this->logger->warning('Lorem Ipsum', ['foo' => 'bar']);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::notice
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::log
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testNotice()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Lorem Ipsum', ['foo' => 'bar', 'severity' => 'notice'], 'Logger');

        $this->logger->notice('Lorem Ipsum', ['foo' => 'bar']);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::info
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::log
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testInfo()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Lorem Ipsum', ['foo' => 'bar', 'severity' => 'info'], 'Logger');

        $this->logger->info('Lorem Ipsum', ['foo' => 'bar']);
    }

    /**
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::debug
     * @covers Fabfuel\Prophiler\Adapter\Psr\Log\Logger::log
     * @uses Fabfuel\Prophiler\Adapter\AdapterAbstract
     */
    public function testDebug()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Lorem Ipsum', ['foo' => 'bar', 'severity' => 'debug'], 'Logger');

        $this->logger->debug('Lorem Ipsum', ['foo' => 'bar']);
    }
}
