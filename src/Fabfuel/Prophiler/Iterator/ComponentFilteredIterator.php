<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 23.11.14, 09:13
 */
namespace Fabfuel\Prophiler\Iterator;

use Fabfuel\Prophiler\ProfilerInterface;

class ComponentFilteredIterator extends \FilterIterator implements \Countable
{
    /**
     * @var string
     */
    protected $component;

    /**
     * @param ProfilerInterface|\Iterator $profiler
     * @param string $component
     */
    public function __construct(ProfilerInterface $profiler, $component)
    {
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
        return $this->current()->getComponent() === $this->component;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count(iterator_to_array($this));
    }
}
