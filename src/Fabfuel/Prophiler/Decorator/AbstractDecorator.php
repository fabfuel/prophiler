<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 21.06.15, 08:38 
 */
namespace Fabfuel\Prophiler\Decorator;

use Fabfuel\Prophiler\ProfilerInterface;

abstract class AbstractDecorator
{
    /**
     * @var ProfilerInterface
     */
    private $profiler;

    /**
     * @var mixed
     */
    private $decorated;

    /**
     * @return string
     */
    abstract public function getComponentName();

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $benchmark = $this->getProfiler()->start($this->getBenchmarkName($name), $arguments, $this->getComponentName());
        $result = call_user_func_array([$this->getDecorated(), $name], $arguments);
        $this->getProfiler()->stop($benchmark);
        return $result;
    }

    /**
     * @param string $methodName
     * @return string
     */
    public function getBenchmarkName($methodName)
    {
        return sprintf('%s::%s', get_class($this->getDecorated()), $methodName);
    }

    /**
     * @return ProfilerInterface
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * @param ProfilerInterface $profiler
     */
    public function setProfiler(ProfilerInterface $profiler)
    {
        $this->profiler = $profiler;
    }

    /**
     * @return mixed
     */
    public function getDecorated()
    {
        return $this->decorated;
    }

    /**
     * @param mixed $decorated
     */
    public function setDecorated($decorated)
    {
        $this->decorated = $decorated;
    }
}