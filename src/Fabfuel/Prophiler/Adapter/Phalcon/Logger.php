<?php
/**
 * @author ogarbe <ogarbe@voyageprive.com>
 * @created 10.12.14, 11:12
 */
namespace Fabfuel\Prophiler\Adapter\Phalcon;

use Fabfuel\Prophiler\Adapter\AdapterAbstract;
use Phalcon\Logger\AdapterInterface;
use Psr\Log\LoggerInterface;

class Logger extends AdapterAbstract implements LoggerInterface, AdapterInterface
{
    protected $formatter;

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        $this->log('alert', $message, $context);

    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        $this->log('critical', $message, $context);

    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        $this->log('error', $message, $context);

    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        $this->log('warning', $message, $context);

    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        $this->log('notice', $message, $context);

    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        $this->log('info', $message, $context);

    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        $this->log('debug', $message, $context);

    }

    /**
     * Logs with an arbitrary level.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $context['severity'] = $level;
        $benchmark = $this->getProfiler()->start($message, $context, 'Logger');
        $this->getProfiler()->stop($benchmark);
    }

    /**
     * Sets the message formatter
     *
     * @param \Phalcon\Logger\FormatterInterface $formatter
     * @return \Phalcon\Logger\Adapter
     */
    public function setFormatter($formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }


    /**
     * Returns the internal formatter
     *
     * @return \Phalcon\Logger\FormatterInterface
     */
    public function getFormatter()
    {
        if (empty($this->formatter) {
            $this->formatter = new \Phalcon\Logger\Formatter\Line();
        }
        return $this->formatter;
    }


    /**
     * Filters the logs sent to the handlers to be greater or equals than a specific level
     *
     * @param int $level
     * @return \Phalcon\Logger\Adapter
     */
    public function setLogLevel($level)
    {
        return $this;
    }


    /**
     * Returns the current log level
     *
     * @return int
     */
    public function getLogLevel()
    {
        return PHP_INT_MAX;
    }


    /**
     * Starts a transaction
     *
     * @return \Phalcon\Logger\Adapter
     */
    public function begin()
    {
        return $this;
    }


    /**
     * Commits the internal transaction
     *
     * @return \Phalcon\Logger\Adapter
     */
    public function commit()
    {
        return $this;
    }


    /**
     * Rollbacks the internal transaction
     *
     * @return \Phalcon\Logger\Adapter
     */
    public function rollback()
    {
        return $this;
    }


    /**
     * Closes the logger
     *
     * @return boolean
     */
    public function close()
    {
        return true;
    }
}
