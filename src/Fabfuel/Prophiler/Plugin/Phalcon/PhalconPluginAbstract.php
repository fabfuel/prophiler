<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 18.11.14, 07:52 
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon;

use Fabfuel\Prophiler\Plugin\PluginAbstract;
use Phalcon\DiInterface;
use Phalcon\DI\InjectionAwareInterface;

abstract class PhalconPluginAbstract extends PluginAbstract implements InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $dependencyInjector;

    /**
     * @param DiInterface $dependencyInjector
     */
    public function setDI($dependencyInjector)
    {
        $this->dependencyInjector = $dependencyInjector;
    }

    /**
     * @return DiInterface
     */
    public function getDI()
    {
        return $this->dependencyInjector;
    }
}
