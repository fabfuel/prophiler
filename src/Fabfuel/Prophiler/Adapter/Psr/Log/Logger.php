<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 23.11.14, 08:46 
 */
namespace Fabfuel\Prophiler\Adapter\Psr\Log;

use Fabfuel\Prophiler\Adapter\AdapterAbstract;
use Psr\Log\LoggerInterface;

class Logger extends AdapterAbstract implements LoggerInterface
{
    const SEVERITY_EMERGENCY = 'emergency';
    const SEVERITY_ALERT = 'alert';
    const SEVERITY_CRITICAL = 'critical';
    const SEVERITY_ERROR = 'error';
    const SEVERITY_WARNING = 'warning';
    const SEVERITY_NOTICE = 'notice';
    const SEVERITY_INFO = 'info';
    const SEVERITY_DEBUG = 'debug';

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        $this->log(self::SEVERITY_EMERGENCY, $message, $context);
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
        $this->log(self::SEVERITY_ALERT, $message, $context);

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
        $this->log(self::SEVERITY_CRITICAL, $message, $context);

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
        $this->log(self::SEVERITY_ERROR, $message, $context);

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
        $this->log(self::SEVERITY_WARNING, $message, $context);

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
        $this->log(self::SEVERITY_NOTICE, $message, $context);

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
        $this->log(self::SEVERITY_INFO, $message, $context);

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
        $this->log(self::SEVERITY_DEBUG, $message, $context);

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
}
