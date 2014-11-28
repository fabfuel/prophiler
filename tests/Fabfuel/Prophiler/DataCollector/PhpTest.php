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
     * @covers Fabfuel\Prophiler\DataCollector\Php::phpInfo_array
     */
    public function testGetData()
    {
        $data = [
            'PHP version' => phpversion(),
            'Phalcon' => extension_loaded('phalcon'),
            'APC' => extension_loaded('apc'),
            'PHP info' => $this->phpInfo_array(),
            'Extensions Loaded' => get_loaded_extensions(),
        ];

        $this->assertSame($data, $this->php->getData());
    }

    protected function phpInfo_array()
    {
        ob_start();
        phpinfo();
        $info_arr = array();
        $info_lines = explode("\n", strip_tags(ob_get_clean(), "<tr><td><h2>"));
        $cat = "General";
        foreach($info_lines as $line)
        {
            // new cat?
            preg_match("~<h2>(.*)</h2>~", $line, $title) ? $cat = $title[1] : null;
            if(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val))
            {
                $info_arr[$cat][$val[1]] = $val[2];
            }
            elseif(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val))
            {
                $info_arr[$cat][$val[1]] = array("local" => $val[2], "master" => $val[3]);
            }
        }
        return $info_arr;
    }
}
