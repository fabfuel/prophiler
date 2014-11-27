<?php
/**
 * @author @marcotroisi <hello@marcotroisi.com>
 * @created 27.11.14
 */
namespace Fabfuel\Prophiler\DataCollector;

use Fabfuel\Prophiler\DataCollectorInterface;

class Php implements DataCollectorInterface
{
    /**
     * Get the title of this data collector
     *
     * @return string
     */
    public function getTitle()
    {
        return 'PHP';
    }

    /**
     * Get the bootstrap icon class
     *
     * @return string
     */
    public function getIcon()
    {
        return 'info-sign';
    }

    /**
     * Get data from the data collector
     *
     * @return array
     */
    public function getData()
    {
        $data = [
            'PHP version' => phpversion(),
            'Phalcon' => extension_loaded('phalcon'),
            'APC' => extension_loaded('apc'),
            'Extensions Loaded' => get_loaded_extensions(),
        ];

        return $data;
    }
}
