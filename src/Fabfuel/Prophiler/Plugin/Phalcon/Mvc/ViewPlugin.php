<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 08:39
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\Plugin\PluginAbstract;
use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ViewInterface;

/**
 * Class Dispatcher
 * @package Rocket\Toolbar\Plugin
 */
class ViewPlugin extends PluginAbstract
{
    /**
     * @var string
     */
    private $token;

    /**
     * All render levels as descriptive strings
     * @var array
     */
    private $renderLevels = [
        View::LEVEL_ACTION_VIEW => 'action',
        View::LEVEL_AFTER_TEMPLATE => 'afterTemplate',
        View::LEVEL_BEFORE_TEMPLATE => 'beforeTemplate',
        View::LEVEL_LAYOUT => 'controller',
        View::LEVEL_MAIN_LAYOUT => 'main'
    ];

    /**
     * Start view benchmark
     *
     * @param Event $event
     * @param ViewInterface $view
     */
    public function beforeRenderView(Event $event, ViewInterface $view)
    {
        $name = get_class($event->getSource()) . '::render: ' . basename($view->getActiveRenderPath());
        $metadata = [
            'view' => realpath($view->getActiveRenderPath()) ?: $view->getActiveRenderPath(),
            'level' => $this->getRenderLevel($view->getCurrentRenderLevel()),
        ];
        $this->token = $this->getProfiler()->start($name, $metadata, 'View');
    }

    /**
     * Stop view benchmark
     */
    public function afterRenderView()
    {
        $this->getProfiler()->stop($this->token);
    }

    /**
     * @param int $renderLevelInt
     * @return string Render level
     */
    public function getRenderLevel($renderLevelInt)
    {
        return isset($this->renderLevels[$renderLevelInt]) ? $this->renderLevels[$renderLevelInt] : '';
    }
}
