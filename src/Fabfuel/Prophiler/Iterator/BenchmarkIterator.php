<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 23.11.14, 09:13
 */
namespace Fabfuel\Prophiler\Iterator;

class BenchmarkIterator extends \FilterIterator
{
    /**
     * Check if the benchmark is not a Logger entry
     *
     * @return bool
     */
    public function accept()
    {
        return $this->current()->getComponent() !== 'Logger';
    }
}
