<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 07.12.14, 13:43
 */
namespace Fabfuel\Prophiler\Decorator\PDO;

use Fabfuel\Prophiler\ProfilerInterface;

/**
 * Class PDOStatement
 * @package Fabfuel\Prophiler\Adapter\PDO
 * @pattern decorator
 * @mixin \PDOStatement
 */
class PDOStatement
{
    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @param \PDOStatement $statement
     * @param ProfilerInterface $profiler
     */
    public function __construct(\PDOStatement $statement, ProfilerInterface $profiler)
    {
        $this->setStatement($statement);
        $this->setProfiler($profiler);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        return call_user_func_array([$this->getStatement(), $name], $arguments);
    }

    /**
     * @param array $input_parameters
     * @return bool
     */
    public function execute(array $input_parameters = null)
    {
        $metadata = [
            'input parameters' => $input_parameters,
            'bound parameters' => $this->parameters,
            'query' => $this->getStatement()->queryString
        ];
        $benchmark = $this->getProfiler()->start('PDOStatement::execute', $metadata, 'Database');
        $result = $this->getStatement()->execute($input_parameters);
        $this->getProfiler()->stop($benchmark);
        return $result;
    }


    /**
     * @param mixed $parameter
     * @param mixed $variable
     * @param int $data_type [optional]
     * @param int $length [optional]
     * @param mixed $driver_options [optional]
     * @return bool
     */
    public function bindParam($parameter, &$variable, $data_type = \PDO::PARAM_STR, $length = null, $driver_options = null)
    {
        $this->parameters[$parameter] = $variable;

        return $this->getStatement()->bindParam($parameter, $variable, $data_type, $length, $driver_options);
    }

    /**
     * @param mixed $column
     * @param mixed $param
     * @param int $type [optional]
     * @param int $maxlen [optional]
     * @param mixed $driverdata [optional]
     * @return bool
     */
    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverdata = null)
    {
        return $this->getStatement()->bindColumn($column, $param, $type, $maxlen, $driverdata);
    }

    /**
     * @return \PDOStatement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param \PDOStatement $statement
     */
    public function setStatement(\PDOStatement $statement)
    {
        $this->statement = $statement;
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
