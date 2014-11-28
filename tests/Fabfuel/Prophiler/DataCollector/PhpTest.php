<?php
/**
 * @author Marco Troisi <hello@marcotroisi.com>
 * @created: 28.11.14
 */

namespace Fabfuel\Prophiler\DataCollector;

class PhpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    protected $php;

    public function setUp()
    {
        $this->php = new Php();
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Php::getTitle
     */
    public function testGetTitle()
    {
        $this->assertSame('PHP', $this->php->getTitle());
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Php::getIcon
     */
    public function testGetIcon()
    {
        $this->assertSame('info-sign', $this->php->getIcon());
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Php::getData
     */
    public function testGetData()
    {
        $data = [
            'PHP version' => phpversion(),
            'Phalcon' => extension_loaded('phalcon'),
            'APC' => extension_loaded('apc'),
            'Extensions Loaded' => get_loaded_extensions(),
        ];

        $this->assertSame($data, $this->php->getData());
    }
}
