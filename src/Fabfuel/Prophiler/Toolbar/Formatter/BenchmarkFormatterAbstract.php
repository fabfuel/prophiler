<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 22.11.14, 08:20
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;
use Fabfuel\Prophiler\Toolbar\Formatter\Encoder\EncoderInterface;

class BenchmarkFormatterAbstract
{
    const NUMBER_COLORS = 5;

    /**
     * @var BenchmarkInterface
     */
    protected $benchmark;

    /**
     * @var EncoderInterface
     */
    protected $encoder;

    /**
     * @return string
     */
    public function getName()
    {
        $encoder = $this->getEncoder();

        return $encoder
            ? $encoder->encode($this->getBenchmark()->getName())
            : $this->getBenchmark()->getName();
    }

    /**
     * @return string
     */
    public function getComponent()
    {
        $encoder = $this->getEncoder();

        return $encoder
            ? $encoder->encode($this->getBenchmark()->getComponent())
            : $this->getBenchmark()->getComponent();
    }

    /**
     * @return BenchmarkInterface
     */
    public function getBenchmark()
    {
        return $this->benchmark;
    }

    /**
     * @param BenchmarkInterface $benchmark
     */
    public function setBenchmark(BenchmarkInterface $benchmark)
    {
        $this->benchmark = $benchmark;
    }

    /**
     * @return EncoderInterface
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * @param EncoderInterface $encoder
     */
    public function setEncoder(EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return spl_object_hash($this->getBenchmark());
    }

    /**
     * @return string
     */
    public function getColorClass()
    {
        return sprintf(
            'color-%s',
            strlen($this->getComponent()) % self::NUMBER_COLORS
        );
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        switch ($this->getBenchmark()->getComponent()) {
            case 'MongoDB':
                return 'leaf';
            default:
                return 'cog';
        }
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->getBenchmark()->getMetadata();
    }

    /**
     * @return double
     */
    public function getStartTime()
    {
        return $this->getBenchmark()->getStartTime();
    }

    /**
     * @return double
     */
    public function getEndTime()
    {
        return $this->getBenchmark()->getEndTime();
    }
}
