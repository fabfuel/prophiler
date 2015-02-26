<?php
/**
 * @author @potfur <wachowski.michal@gmail.com>
 * @created 26.02.15, 22:57
 */

namespace Fabfuel\Prophiler\DataCollector;

class GenericTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Generic
     */
    protected $generic;

    public function setUp()
    {
        $this->generic = new Generic();
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Generic::setTitle
     * @covers Fabfuel\Prophiler\DataCollector\Generic::getTitle
     */
    public function testTitle()
    {
        $this->generic->setTitle('Generic');
        $this->assertSame('Generic', $this->generic->getTitle());
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Generic::setIcon
     * @covers Fabfuel\Prophiler\DataCollector\Generic::getIcon
     */
    public function testIcon()
    {
        $this->generic->setIcon('fa-circle-thin');
        $this->assertSame('<i class="fa fa-circle-thin"></i>', $this->generic->getIcon());
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Generic::setIcon
     * @covers Fabfuel\Prophiler\DataCollector\Generic::getIcon
     */
    public function testEmptyIcon()
    {
        $this->generic->setIcon(null);
        $this->assertSame('', $this->generic->getIcon());
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Generic::setData
     * @covers Fabfuel\Prophiler\DataCollector\Generic::getData
     */
    public function testData()
    {
        $data = [
            'foo' => 1,
            'bar' => 'bar',
            'yada' => [1,2,3],
            'pebble' => new \stdClass()
        ];
        $this->generic->setData($data);
        $this->assertSame($data, $this->generic->getData());
    }
}
