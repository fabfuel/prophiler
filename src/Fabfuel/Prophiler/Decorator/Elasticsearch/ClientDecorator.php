<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 19.06.15 14:29
 */

namespace Fabfuel\Prophiler\Decorator\Elasticsearch;

use Elasticsearch\Client;
use Fabfuel\Prophiler\ProfilerInterface;

/**
 * Elasticsearch client decorator
 *
 * Class ClientDecorator
 * @package Common\Prophiler\Decorator\Elasticsearch
 */
class ClientDecorator
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ProfilerInterface
     */
    private $profiler;

    /**
     * @param Client $client
     * @param ProfilerInterface $profiler
     */
    public function __construct(Client $client, ProfilerInterface $profiler)
    {
        $this->setClient($client);
        $this->setProfiler($profiler);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $benchmark = $this->getProfiler()->start($this->getBenchmarkName($name), current($arguments), 'Elasticsearch');
        $result = call_user_func_array([$this->getClient(), $name], $arguments);
        $this->getProfiler()->stop($benchmark);
        return $result;
    }

    /**
     * @param string $method
     * @return string
     */
    public function getBenchmarkName($method)
    {
        return sprintf('%s::%s', get_class($this->getClient()), $method);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
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
}
