<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 25.11.14, 08:12 
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Phalcon\Events\Event;
use Phalcon\Mvc\ViewInterface;

interface ViewPluginInterface
{
    /**
     * @param Event $event
     * @param ViewInterface $view
     * @return void
     */
    public function beforeRenderView(Event $event, ViewInterface $view);

    /**
     * @param Event $event
     * @param ViewInterface $view
     * @return void
     */
    public function afterRenderView(Event $event, ViewInterface $view);

    /**
     * @param Event $event
     * @param ViewInterface $view
     * @return void
     */
    public function afterRender(Event $event, ViewInterface $view);
}
