<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 08:39
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Db;

use Fabfuel\Prophiler\Plugin\Phalcon\PhalconPluginAbstract;
use Phalcon\Events\Event;
use Phalcon\Db\Adapter;

/**
 * Class Dispatcher
 * @package Rocket\Toolbar\Plugin
 */
class AdapterPlugin extends PhalconPluginAbstract
{
    /**
     * @var string
     */
    private $token;

    /**
     * Start the query benchmark
     *
     * @param Event $event
     * @param Adapter $database
     */
    public function beforeQuery(Event $event, Adapter $database)
    {
        $metadata = [
            'query' => $database->getSQLStatement()
        ];

        $this->token = $this->getProfiler()->start(get_class($event->getSource()) . '::query', $metadata, 'Database');
    }

    /**
     * Stop the query benchmark
     */
    public function afterQuery()
    {
        $this->getProfiler()->stop($this->token);
    }
}
