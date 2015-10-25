<?php
/**
 * @author @shochdoerfer <S.Hochdoerfer@bitExpert.de>
 * @created 18.10.15, 12:14
 */
namespace Fabfuel\Prophiler\Adapter\Interop\Container;

use Fabfuel\Prophiler\Adapter\AdapterAbstract;
use Fabfuel\Prophiler\ProfilerInterface;
use Interop\Container\ContainerInterface;

class Container extends AdapterAbstract implements ContainerInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Creates a new {@link \Fabfuel\Prophiler\Adapter\Interop\Container\Container}.
     *
     * @param ContainerInterface $container
     * @param ProfilerInterface $profiler
     */
    public function __construct(ContainerInterface $container, ProfilerInterface $profiler)
    {
        parent::__construct($profiler);
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        $entry = null;
        $metadata = [
            'id' => $id
        ];

        try {
            $benchmark = $this->profiler->start('Container::get', $metadata, 'Container-Interop');
            $entry = $this->container->get($id);
        } catch (\Exception $e) {
            // exception needs to be catched and thrown after stopping the profiler
        }

        $this->profiler->stop($benchmark);

        if (isset($e)) {
            throw $e;
        }

        return $entry;
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        $metadata = [
            'id' => $id
        ];
        $benchmark = $this->profiler->start('Container::has', $metadata, 'Container-Interop');

        $has = $this->container->has($id);

        $this->profiler->stop($benchmark);
        return $has;
    }
}
