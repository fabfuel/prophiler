<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 19.06.15 14:29
 */

namespace Fabfuel\Prophiler\Decorator\Elasticsearch;

use Elasticsearch\Client;
use Fabfuel\Prophiler\Decorator\AbstractDecorator;
use Fabfuel\Prophiler\ProfilerInterface;

/**
 * Elasticsearch client decorator
 *
 * Class ClientDecorator
 * @package Common\Prophiler\Decorator\Elasticsearch
 */
class ClientDecorator extends AbstractDecorator
{
    /**
     * @param Client $client
     * @param ProfilerInterface $profiler
     */
    public function __construct(Client $client, ProfilerInterface $profiler)
    {
        $this->setDecorated($client);
        $this->setProfiler($profiler);
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return 'Elasticsearch';
    }
}
