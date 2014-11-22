<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 17.11.14, 07:49 
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;

interface BenchmarkFormatterInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getComponent();

    /**
     * @return string
     */
    public function getMemoryUsage();

    /**
     * @return string
     */
    public function getDuration();

    /**
     * @return string
     */
    public function getColorClass();

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return BenchmarkInterface
     */
    public function getBenchmark();

    /**
     * @return double
     */
    public function getStartTime();

    /**
     * @return double
     */
    public function getEndTime();

    /**
     * @return array
     */
    public function getMetadata();
}
