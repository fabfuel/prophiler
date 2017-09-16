<?php

namespace Fabfuel\Prophiler\Toolbar\Formatter\Encoder;

class HtmlEncoderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var HtmlEncoder
     */
    protected $encoder;

    public function setUp()
    {
        $this->encoder = new HtmlEncoder();
    }

    /**
     * @dataProvider getEncode
     */
    public function testEncode($encode, $expected)
    {
        $this->assertSame($expected, $this->encoder->encode($encode));
    }

    public function getEncode()
    {
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $metadata = ['lorem' => 'ipsum'];
        $time = microtime(true);

        return [
            ['<Foobar "&\'>', '&lt;Foobar &quot;&amp;&apos;&gt;'],
            ['<Foobar&nbsp;"&\'>', '&lt;Foobar&nbsp;&quot;&amp;&apos;&gt;'],
            [$benchmark, $benchmark],
            [$metadata, $metadata],
            [$time, $time],
        ];
    }
}
