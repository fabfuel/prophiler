<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 17.11.14, 07:49 
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

interface BenchmarkFormatterInterface
{
    public function getId();
    public function getName();
    public function getComponent();
    public function getMemoryUsage();
    public function getDuration();
    public function getLabel();
    public function getIcon();
    public function getBenchmark();
    public function getStartTime();
    public function getEndTime();
    public function getMetadata();
}
