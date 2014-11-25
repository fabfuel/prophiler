<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 14.11.14 12:13
 */

namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\Plugin\Phalcon\PhalconPluginTest;

class ViewPluginTest extends PhalconPluginTest
{
    /**
     * @var ViewPlugin
     */
    protected $viewPlugin;

    public function setUp()
    {
        parent::setUp();
        $this->viewPlugin = ViewPlugin::getInstance($this->getProfiler());
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::beforeRenderView
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::afterRenderView
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getRenderLevel
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::setToken
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getToken
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testRenderView()
    {
        $token = 'token';

        $view = $this->getMockBuilder('Phalcon\Mvc\View')
            ->disableOriginalConstructor()
            ->getMock();

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->exactly(1))
            ->method('getSource')
            ->willReturn($view);

        $view->expects($this->once())
            ->method('getCurrentRenderLevel')
            ->willReturn(1);

        $view->expects($this->exactly(5))
            ->method('getActiveRenderPath')
            ->willReturn('main');

        $metadata = [
            'view' => 'main',
            'level' => 'action',
        ];

        $this->profiler->expects($this->once())
            ->method('start')
            ->with(get_class($view) . '::render: main', $metadata, 'View')
            ->willReturn($token);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($token);

        $this->viewPlugin->beforeRenderView($event, $view);
        $this->viewPlugin->afterRenderView($event, $view);
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::afterRender
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testAfterRenderWithoutOpenTokens()
    {
        $view = $this->getMockBuilder('Phalcon\Mvc\View')
            ->disableOriginalConstructor()
            ->getMock();

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $this->getProfiler()
            ->expects($this->never())
            ->method('stop');

        $this->viewPlugin->afterRender($event, $view);
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::afterRender
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testAfterRender()
    {
        $view = $this->getMockBuilder('Phalcon\Mvc\View')
            ->disableOriginalConstructor()
            ->getMock();

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $view = $this->getMockBuilder('Phalcon\Mvc\View')
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewPlugin->setToken($view, 'token');

        $this->getProfiler()
            ->expects($this->once())
            ->method('stop')
            ->with('token');

        $this->viewPlugin->afterRender($event, $view);
    }

    /**
     * @param $renderLevelInt
     * @param $renderLevelString
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getRenderLevel
     * @covers Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     * @dataProvider getRenderLevels
     */
    public function testGetRenderLevel($renderLevelInt, $renderLevelString)
    {
        $this->assertSame($renderLevelString, $this->viewPlugin->getRenderLevel($renderLevelInt));
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getIdentifier
     * @covers Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testGetIdentifier()
    {
        $view = $this->getMockBuilder('Phalcon\Mvc\View')
            ->disableOriginalConstructor()
            ->getMock();

        $view->expects($this->once())
            ->method('getActiveRenderPath')
            ->willReturn('test');

        $this->assertSame(md5('test'), $this->viewPlugin->getIdentifier($view));
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getToken
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::setToken
     * @covers Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testGetAndSetToken()
    {
        $view = $this->getMockBuilder('Phalcon\Mvc\View')
            ->disableOriginalConstructor()
            ->getMock();

        $view->expects($this->exactly(5))
            ->method('getActiveRenderPath')
            ->willReturn('test');

        $this->viewPlugin->setToken($view, 'token1');
        $this->viewPlugin->setToken($view, 'token2');

        $this->assertSame('token1', $this->viewPlugin->getToken($view));
        $this->assertSame('token2', $this->viewPlugin->getToken($view));
        $this->assertNull($this->viewPlugin->getToken($view));
    }

    /**
     * @return array
     */
    public function getRenderLevels()
    {
        return [
            [\Phalcon\Mvc\View::LEVEL_ACTION_VIEW, 'action'],
            [\Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE, 'afterTemplate'],
            [\Phalcon\Mvc\View::LEVEL_BEFORE_TEMPLATE, 'beforeTemplate'],
            [\Phalcon\Mvc\View::LEVEL_LAYOUT, 'controller'],
            [\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT, 'main'],
            ['foobar', ''],
            ['lorem', ''],
            ['', ''],
        ];
    }
}
