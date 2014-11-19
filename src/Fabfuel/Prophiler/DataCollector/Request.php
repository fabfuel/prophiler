<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 19.11.14, 07:03 
 */
namespace Fabfuel\Prophiler\DataCollector;

use Fabfuel\Prophiler\DataCollectorInterface;

class Request implements DataCollectorInterface
{
    /**
     * Get the title of this data collector
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Request';
    }

    /**
     * Get the bootstrap icon class
     *
     * @return string
     */
    public function getIcon()
    {
        return 'log-in';
    }

    /**
     * Get data from the data collector
     *
     * @return array
     */
    public function getData()
    {
        $data = [
            'SERVER' => $_SERVER,
            'GET' => $_GET,
            'POST' => $_POST,
            'COOKIE' => $_COOKIE,
            'FILES' => $_FILES,
        ];

        if (isset($_SESSION)) {
            $data['SESSION'] = $_SESSION;
        }

        return $data;
    }
}
