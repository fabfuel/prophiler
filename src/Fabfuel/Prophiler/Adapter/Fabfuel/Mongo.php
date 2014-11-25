<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 20:41 
 */
namespace Fabfuel\Prophiler\Adapter\Fabfuel;

use Fabfuel\Prophiler\Adapter\AdapterAbstract;
use Mongo\Profiler\ProfilerInterface;

/**
 * Class Mongo
 * Profiler adapter for Fabfuel\Mongo
 *
 * Usage:
 * $profiler = new \Fabfuel\Prophiler\Profiler();
 * $adapter = new \Fabfuel\Prophiler\Adapter\Fabfuel\Mongo($profiler);
 * $mongoDb->setProfiler($adapter);
 *
 * @package Fabfuel\Prophiler\Adapter\Fabfuel
 */
class Mongo extends AdapterAbstract implements ProfilerInterface
{
    /**
     * Start a new benchmark
     *
     * @param string $name Unique identifier like e.g. Class::Method (\Foobar\MyClass::doSomething)
     * @param array $metadata Addtional interesting metadata for this benchmark
     * @return string identifier token
     */
    public function start($name, array $metadata = [])
    {
        return $this->getProfiler()->start($name, $metadata, 'MongoDB');
    }

    /**
     * Stop a running benchmark
     *
     * @param string $token benchmark identifier
     * @return void
     */
    public function stop($token)
    {
        $this->getProfiler()->stop($token);
    }
}
