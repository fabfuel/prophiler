<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 07.12.14, 13:12 
 */
namespace Fabfuel\Prophiler\Decorator\PDO;

use Fabfuel\Prophiler\ProfilerInterface;

/**
 * Class PDO
 * @package Fabfuel\Prophiler\Adapter\Pdo
 * @pattern decorator
 * @mixin \PDOStatement
 */
class PDO
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @param \PDO $pdo
     * @param ProfilerInterface $profiler
     */
    public function __construct(\PDO $pdo, ProfilerInterface $profiler)
    {
        $this->setPdo($pdo);
        $this->setProfiler($profiler);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        return call_user_func_array([$this->getPdo(), $name], $arguments);
    }

    /**
     * @param string $statement
     * @return \PDOStatement
     */
    public function query($statement)
    {
        $benchmark = $this->getProfiler()->start('PDO::query', ['statement' => $statement], 'Database');
        $result = $this->getPdo()->query($statement);
        $this->getProfiler()->stop($benchmark, ['rows' => $result->rowCount(), 'columns' => $result->columnCount()]);
        return $result;
    }

    /**
     * @param string $statement
     * @return int Number of rows affected
     */
    public function exec($statement)
    {
        $benchmark = $this->getProfiler()->start('PDO::exec', ['statement' => $statement], 'Database');
        $result = $this->getPdo()->exec($statement);
        $this->getProfiler()->stop($benchmark, ['affected rows' => $result]);
        return $result;
    }

    /**
     * @param string $statement
     * @param array $options
     * @return \PDOStatement|void
     */
    public function prepare($statement, $options = null)
    {
        $benchmark = $this->getProfiler()->start('PDO::prepare', ['statement' => $statement], 'Database');
        $pdoStatement = $this->getPdo()->prepare($statement, $options ?: []);
        $profiledStatement = new PDOStatement($pdoStatement, $this->getProfiler());
        $this->getProfiler()->stop($benchmark);
        return $profiledStatement;
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param \PDO $pdo
     */
    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return ProfilerInterface
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * @param ProfilerInterface $profiler
     */
    public function setProfiler(ProfilerInterface $profiler)
    {
        $this->profiler = $profiler;
    }
}
