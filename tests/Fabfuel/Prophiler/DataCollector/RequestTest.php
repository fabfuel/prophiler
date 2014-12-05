<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 19.11.14 14:46
 */

namespace Fabfuel\Prophiler\DataCollector;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    protected $request;

    public function setUp()
    {
        $this->request = new Request();
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Request::getTitle
     */
    public function testGetTitle()
    {
        $this->assertSame('Request', $this->request->getTitle());
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Request::getIcon
     */
    public function testGetIcon()
    {
        $this->assertSame('<i class="fa fa-arrow-circle-o-down"></i>', $this->request->getIcon());
    }

    /**
     * @covers Fabfuel\Prophiler\DataCollector\Request::getData
     */
    public function testGetData()
    {
        $_SESSION = ['lorem' => 'ipsum'];

        $data = [
            'SERVER' => $_SERVER,
            'GET' => $_GET,
            'POST' => $_POST,
            'COOKIE' => $_COOKIE,
            'FILES' => $_FILES,
            'SESSION' => $_SESSION,
        ];
        $this->assertSame($data, $this->request->getData());
    }
}
