<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 16.11.14, 16:34
 */
namespace Fabfuel\Prophiler;

use Phalcon\DI\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\ViewInterface;

class Toolbar extends Injectable
{
    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @var DataCollectorInterface[]
     */
    protected $dataCollectors = [];

    /**
     * @param ProfilerInterface $profiler
     */
    public function __construct(ProfilerInterface $profiler)
    {
        $this->setProfiler($profiler);
    }

    /**
     * Render the toolbar
     */
    public function render()
    {
        ob_start();
        $this->partial('toolbar', ['profiler' => $this->getProfiler(), 'dataCollectors' => $this->getDataCollectors()]);
        return ob_get_clean();
    }

    /**
     * @param string $viewPath
     * @param array $params
     */
    public function partial($viewPath, array $params = [])
    {
        foreach ($params as $paramName => $param) {
            $$paramName = $param;
        }
        require __DIR__ . '/View/' . $viewPath . '.phtml';
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

    /**
     * Add a data collector to the profiler
     *
     * @param DataCollectorInterface $dataCollector
     * @return $this
     */
    public function addDataCollector(DataCollectorInterface $dataCollector)
    {
        $this->dataCollectors[] = $dataCollector;
    }

    /**
     * @return DataCollectorInterface[]
     */
    public function getDataCollectors()
    {
        return $this->dataCollectors;
    }

    public function afterRender(Event $event, ViewInterface $view)
    {
        $view->setContent(
            str_replace(
                "</body>",
                $this->render() . "</body>",
                $view->getContent()
            )
        );
    }

    public function setEventsManager($eventsManager)
    {
        $eventsManager->attach('view:afterRender', $this);
        parent::setEventsManager($eventsManager);
    }
}
