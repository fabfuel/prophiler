<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 19.06.15 14:52
 */

namespace Fabfuel\Prophiler\Decorator\Phalcon\Cache;

use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\Cache\BackendInterface;

/**
 * Class BackendDecorator
 * @package Common\Prophiler\Decorator\Phalcon\Cache
 */
class BackendDecorator implements BackendInterface
{
    /**
     * @var BackendInterface
     */
    private $backend;

    /**
     * @var ProfilerInterface
     */
    private $profiler;

    /**
     * @param BackendInterface $backend
     * @param ProfilerInterface $profiler
     */
    public function __construct(BackendInterface $backend, ProfilerInterface $profiler)
    {
        $this->setBackend($backend);
        $this->setProfiler($profiler);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $benchmark = $this->getProfiler()->start($this->getBenchmarkName($name), $arguments, $this->getComponentName());
        $result = call_user_func_array([$this->getBackend(), $name], $arguments);
        $this->getProfiler()->stop($benchmark);
        return $result;
    }

    /**
     * @param string $method
     * @return string
     */
    public function getBenchmarkName($method)
    {
        $name = sprintf('%s::%s', get_class($this->getBackend()), $method);
        return $name;
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        $class = get_class($this->getBackend());
        $class = basename(str_replace('\\', '/', $class));
        return sprintf('Cache %s', $class);
    }

    /**
     * Starts a cache. The $keyname allows to identify the created fragment
     *
     * @param int|string $keyName
     * @param   int $lifetime
     * @return  mixed
     */
    public function start($keyName, $lifetime = null)
    {
        return $this->__call('start', [$keyName, $lifetime]);
    }

    /**
     * Stops the frontend without store any cached content
     *
     * @param boolean $stopBuffer
     * @return mixed
     */
    public function stop($stopBuffer = null)
    {
        return $this->__call('stop', [$stopBuffer]);
    }

    /**
     * Returns front-end instance adapter related to the back-end
     *
     * @return mixed
     */
    public function getFrontend()
    {
        return $this->__call('getFrontend', []);
    }

    /**
     * Returns the backend options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->__call('getOptions', []);
    }

    /**
     * Checks whether the last cache is fresh or cached
     *
     * @return boolean
     */
    public function isFresh()
    {
        return $this->__call('isFresh', []);
    }

    /**
     * Checks whether the cache has starting buffering or not
     *
     * @return boolean
     */
    public function isStarted()
    {
        return $this->__call('isStarted', []);
    }

    /**
     * Sets the last key used in the cache
     *
     * @param string $lastKey
     * @return mixed
     */
    public function setLastKey($lastKey)
    {
        return $this->__call('setLastKey', [$lastKey]);
    }

    /**
     * Gets the last key stored by the cache
     *
     * @return string
     */
    public function getLastKey()
    {
        return $this->__call('getLastKey', []);
    }

    /**
     * Returns a cached content
     *
     * @param int|string $keyName
     * @param   int $lifetime
     * @return  mixed
     */
    public function get($keyName, $lifetime = null)
    {
        return $this->__call('get', [$keyName, $lifetime]);
    }

    /**
     * Stores cached content into the file backend and stops the frontend
     *
     * @param int|string $keyName
     * @param string $content
     * @param int $lifetime
     * @param boolean $stopBuffer
     * @return mixed
     */
    public function save($keyName = null, $content = null, $lifetime = null, $stopBuffer = null)
    {
        return $this->__call('save', [$keyName, $content, $lifetime, $stopBuffer]);
    }

    /**
     * Deletes a value from the cache by its key
     *
     * @param int|string $keyName
     * @return boolean
     */
    public function delete($keyName)
    {
        return $this->__call('delete', [$keyName]);
    }

    /**
     * Query the existing cached keys
     *
     * @param string $prefix
     * @return array
     */
    public function queryKeys($prefix = null)
    {
        return $this->__call('queryKeys', [$prefix]);
    }

    /**
     * Checks if cache exists and it hasn't expired
     *
     * @param  string $keyName
     * @param  int $lifetime
     * @return boolean
     */
    public function exists($keyName = null, $lifetime = null)
    {
        return $this->__call('exists', [$keyName, $lifetime]);
    }

    /**
     * Immediately invalidates all existing items.
     *
     * @return boolean
     */
    public function flush()
    {
        return $this->__call('flush', []);
    }


    /**
     * @return BackendInterface
     */
    public function getBackend()
    {
        return $this->backend;
    }

    /**
     * @param BackendInterface $backend
     */
    public function setBackend($backend)
    {
        $this->backend = $backend;
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
    public function setProfiler($profiler)
    {
        $this->profiler = $profiler;
    }
}
