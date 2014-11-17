<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 16.11.14, 16:34
 */
namespace Fabfuel\Prophiler;

use Fabfuel\Prophiler\Plugin\Phalcon\Db\AdapterPlugin;
use Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin;
use Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin;
use Phalcon\DI\Injectable;
use Phalcon\Mvc\View\Simple;

class Toolbar extends Injectable
{
    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @param ProfilerInterface $profiler
     */
    public function __construct(ProfilerInterface $profiler)
    {
        $this->setProfiler($profiler);
    }

    /**
     * Register default plugins to events manager
     *
     * @return $this
     */
    public function register()
    {
        $this->eventsManager->attach('dispatch', new DispatcherPlugin($this->getProfiler(), $this->dispatcher));
        $this->eventsManager->attach('view', new ViewPlugin($this->getProfiler()));
        $this->eventsManager->attach('db', new AdapterPlugin($this->getProfiler()));

        return $this;
    }

    /**
     * Render the toolbar
     */
    public function render()
    {
        $toolbar = new Simple();
        $toolbar->setViewsDir(__DIR__ . '/View/');
        echo $toolbar->render('toolbar', ['profiler' => $this->getProfiler()]);
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
    public function setProfiler($profiler)
    {
        $this->profiler = $profiler;
    }
}
