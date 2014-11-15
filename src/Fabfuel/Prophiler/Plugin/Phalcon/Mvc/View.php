<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 08:39
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\DI\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\ViewInterface;

/**
 * Class Dispatcher
 * @package Rocket\Toolbar\Plugin
 * @property ProfilerInterface $profiler
 */
class View extends Injectable
{
    /**
     * @var string
     */
    private $token;

    /**
     * Alll render levels as descriptive strings
     * @var array
     */
    private $renderLevels = [
        \Phalcon\Mvc\View::LEVEL_ACTION_VIEW => 'action',
        \Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE => 'afterTemplate',
        \Phalcon\Mvc\View::LEVEL_BEFORE_TEMPLATE => 'beforeTemplate',
        \Phalcon\Mvc\View::LEVEL_LAYOUT => 'controller',
        \Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT => 'main'
    ];

    /**
     * Start view benchmark
     *
     * @param Event $event
     * @param ViewInterface $view
     */
    public function beforeRenderView(Event $event, ViewInterface $view)
    {
        $metadata = [
            'view' => $view->getActiveRenderPath(),
            'level' => $this->getRenderLevel($view->getCurrentRenderLevel()),
        ];
        $name = get_class($event->getSource()) . '::render: ' . $this->getRenderLevel($view->getCurrentRenderLevel());
        $this->token = $this->profiler->start($name, $metadata, 'View');
    }

    /**
     * Stop view benchmark
     */
    public function afterRenderView()
    {
        $this->profiler->stop($this->token);
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
