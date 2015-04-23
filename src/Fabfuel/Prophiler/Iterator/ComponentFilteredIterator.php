<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 23.11.14, 09:13
 */
namespace Fabfuel\Prophiler\Iterator;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;
use Fabfuel\Prophiler\ProfilerInterface;

/**
 * Class ComponentFilteredIterator
 * @package Fabfuel\Prophiler\Iterator
 * @method BenchmarkInterface current
 */
class ComponentFilteredIterator extends \FilterIterator implements \Countable
{
    /**
     * @var string
     */
    protected $component;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @param ProfilerInterface|\Iterator $profiler
     * @param string $component
     * @param array $filters Additional filters (e.g. ['severity' => ['alert', 'emergency', 'error']
     */
    public function __construct(ProfilerInterface $profiler, $component, array $filters = [])
    {
        $this->filters = $filters;
        $this->component = $component;
        parent::__construct($profiler);
    }

    /**
     * Check if the benchmark belongs to the predefined component
     *
     * @return bool
     */
    public function accept()
    {
        if ($this->current()->getComponent() !== $this->component) {
            return false;
        }
        return $this->acceptFilters();
    }

    /**
     * @return bool
     */
    protected function acceptFilters()
    {
        foreach ($this->filters as $field => $value) {
            if ($this->acceptFilter($this->current(), $field, $value) !== true) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param BenchmarkInterface $benchmark
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    protected function acceptFilter(BenchmarkInterface $benchmark, $field, $value)
    {
        if (is_array($value)) {
            return in_array($benchmark->getMetadataValue($field), $value, true);
        }
        return $benchmark->getMetadataValue($field) === $value;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count(iterator_to_array($this));
    }
}
