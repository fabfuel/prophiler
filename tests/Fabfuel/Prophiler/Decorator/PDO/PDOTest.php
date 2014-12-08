<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 07.12.14, 16:18 
 */
namespace Fabfuel\Prophiler\Decorator\PDO;

use Fabfuel\Prophiler\ProfilerInterface;

class PDOTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PDO
     */
    protected $decorator;

    /**
     * @var ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    /**
     * @var \PDO|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pdo;

    public function setUp()
    {
        $this->profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');
        $this->pdo = $this->getMock('Fabfuel\Prophiler\Mock\PDO', ['query', 'exec', 'prepare', 'foobar']);
        $this->decorator = new PDO($this->pdo, $this->profiler);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::__construct
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::getProfiler
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::setProfiler
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::getPdo
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::setPdo
     */
    public function testConstruct()
    {
        $this->assertSame($this->profiler, $this->decorator->getProfiler());
        $this->assertSame($this->pdo, $this->decorator->getPdo());
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::__call
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDO
     */
    public function testCall()
    {
        $this->pdo->expects($this->once())
            ->method('foobar')
            ->with('lorem', 'ipsum');

        $this->decorator->foobar('lorem', 'ipsum');
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::query
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDO
     */
    public function testQuery()
    {
        $query = 'SELECT * FROM users;';
        $rowCount = 4;
        $columnCount = 10;
        $statement = $this->getMock('\PDOStatement');
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $statement->expects($this->once())
            ->method('rowCount')
            ->willReturn($rowCount);

        $statement->expects($this->once())
            ->method('columnCount')
            ->willReturn($columnCount);

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('PDO::query', [], 'Database')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark, ['statement' => $query, 'rows' => $rowCount, 'columns' => $columnCount]);

        $this->pdo->expects($this->once())
            ->method('query')
            ->with($query)
            ->willReturn($statement);

        $result = $this->decorator->query($query);

        $this->assertSame($statement, $result);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::exec
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDO
     */
    public function testExec()
    {
        $query = 'DELETE FROM users;';
        $rowCount = 10;
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('PDO::exec', [], 'Database')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark, ['statement' => $query, 'affected rows' => $rowCount]);

        $this->pdo->expects($this->once())
            ->method('exec')
            ->with($query)
            ->willReturn($rowCount);

        $result = $this->decorator->exec($query);

        $this->assertSame($rowCount, $result);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::prepare
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDO
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDOStatement
     */
    public function testPrepare()
    {
        $query = 'SELECT * FROM users;';
        $options = ['foo' => 'bar'];
        $pdoStatement = $this->getMock('\PDOStatement');
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('PDO::prepare', ['statement' => $query], 'Database')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($query, $options)
            ->willReturn($pdoStatement);

        $statement = $this->decorator->prepare($query, $options);

        $this->assertInstanceOf('Fabfuel\Prophiler\Decorator\PDO\PDOStatement', $statement);
        $this->assertSame($statement->getStatement(), $pdoStatement);
        $this->assertSame($statement->getProfiler(), $this->profiler);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\PDO\PDO::prepare
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDO
     * @uses Fabfuel\Prophiler\Decorator\PDO\PDOStatement
     */
    public function testPrepareInvalidStatement()
    {
        $query = 'SELECT * FROM users;';
        $options = ['foo' => 'bar'];
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('PDO::prepare', ['statement' => $query], 'Database')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($query, $options)
            ->willReturn(false);

        $statement = $this->decorator->prepare($query, $options);

        $this->assertFalse($statement);
    }
}
