<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 08:39
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Db;

use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\DI\Injectable;
use Phalcon\Events\Event;
use Phalcon\Db\Adapter as DbAdapter;

/**
 * Class Dispatcher
 * @package Rocket\Toolbar\Plugin
 * @property ProfilerInterface $profiler
 */
class Adapter extends Injectable
{
    /**
     * @var string
     */
    private $token;

    /**
     * Start the query benchmark
     *
     * @param Event $event
     * @param DbAdapter $database
     */
    public function beforeQuery(Event $event, DbAdapter $database)
    {
        $metadata = [
            'query' => $database->getSQLStatement()
        ];

        $this->token = $this->profiler->start(get_class($event->getSource()) . '::query', $metadata, 'Database');
    }

    /**
     * Stop the query benchmark
     */
    public function afterQuery()
    {
        $this->profiler->stop($this->token);
    }
}
