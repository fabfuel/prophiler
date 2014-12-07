<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 07.12.14, 16:18 
 */
namespace Fabfuel\Prophiler\Decorator\PDO;

use Fabfuel\Prophiler\ProfilerInterface;

class PDOStatementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PDOStatement
     */
    protected $decorator;

    /**
     * @var ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    /**
     * @var \PDOStatement|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pdoStatement;

    public function setUp()
    {
        $this->profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');
        $this->pdoStatement = $this->getMock('\PDOStatement', ['execute', 'bindParam', 'bindColumn', 'foobar']);
        $this->decorator = new PDOStatement($this->pdoStatement, $this->profiler);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::__construct
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::getProfiler
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::setProfiler
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::getStatement
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::setStatement
     */
    public function testConstruct()
    {
        $this->assertSame($this->profiler, $this->decorator->getProfiler());
        $this->assertSame($this->pdoStatement, $this->decorator->getStatement());
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::__call
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDOStatement
     */
    public function testCall()
    {
        $this->pdoStatement->expects($this->once())
            ->method('foobar')
            ->with('lorem', 'ipsum');

        $this->decorator->foobar('lorem', 'ipsum');
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::bindParam
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDOStatement
     */
    public function testBindParam()
    {
        $parameter = 'foo';
        $variable = 'bar';
        $data_type = \PDO::PARAM_STR;
        $length = 15;
        $driver_options = 'lorem ipsum';

        $this->pdoStatement->expects($this->once())
            ->method('bindParam')
            ->with($parameter, $variable, $data_type, $length, $driver_options)
            ->willReturn(true);

        $this->assertTrue($this->decorator->bindParam($parameter, $variable, $data_type, $length, $driver_options));
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::bindColumn
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDOStatement
     */
    public function testBindColumn()
    {
        $column = 'foo';
        $param = 'bar';
        $type = \PDO::PARAM_STR;
        $maxlen = 15;
        $driverdata = 'lorem ipsum';

        $this->pdoStatement->expects($this->once())
            ->method('bindColumn')
            ->with($column, $param, $type, $maxlen, $driverdata)
            ->willReturn(true);

        $this->assertTrue($this->decorator->bindColumn($column, $param, $type, $maxlen, $driverdata));
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::execute
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDOStatement::bindParam
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDOStatement
     */
    public function testExecute()
    {
        $lorem = 'ipsum';
        $inputParameters = ['foo' => 'bar'];
        $boundParameters = ['lorem' => $lorem];
        $metadata = [
            'input parameters' => $inputParameters,
            'bound parameters' => $boundParameters,
            'query' => null
        ];

        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('PDOStatement::execute', $metadata, 'Database')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $this->pdoStatement->expects($this->once())
            ->method('execute')
            ->with($inputParameters)
            ->willReturn(true);

        $this->decorator->bindParam('lorem', $lorem);

        $result = $this->decorator->execute($inputParameters);

        $this->assertTrue($result);
    }
}
