<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 16.11.14, 16:34
 */
namespace Fabfuel\Prophiler;

use Fabfuel\Prophiler\Adapter\Psr\Log\Logger;
use Fabfuel\Prophiler\Iterator\ComponentFilteredIterator;

class Toolbar
{
    protected $alertSeverities = [
        Logger::SEVERITY_ALERT,
        Logger::SEVERITY_ERROR,
        Logger::SEVERITY_EMERGENCY,
        Logger::SEVERITY_CRITICAL
    ];

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
        $alerts = new ComponentFilteredIterator(
            $this->profiler,
            'Logger',
            ['severity' => $this->alertSeverities]
        );

        ob_start();
        $this->partial('toolbar', [
            'profiler' => $this->getProfiler(),
            'dataCollectors' => $this->getDataCollectors(),
            'aggregators' => $this->getProfiler()->getAggregators(),
            'alertCount' => count($alerts)
        ]);
        return ob_get_clean();
    }

    /**
     * @param string $viewPath
     * @param array $params
     */
    public function partial($viewPath, array $params = [])
    {
        extract($params, EXTR_OVERWRITE);
        $viewScriptPath = __DIR__ . '/View/' . $viewPath . '.phtml';

        if (!file_exists($viewScriptPath)) {
            throw new \InvalidArgumentException(sprintf(
                'View not found: %s',
                $viewScriptPath
            ));
        }
        require $viewScriptPath;
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
}
