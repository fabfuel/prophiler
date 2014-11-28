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
            'PHP info' => $this->phpInfo_array(),
            'Extensions Loaded' => get_loaded_extensions(),
        ];

        return $data;
    }

    /**
     * Returns the phpinfo() values as an array
     *
     * @return array
     */
    protected function phpInfo_array()
    {
        ob_start();
        phpinfo();
        $info_arr = array();
        $info_lines = explode("\n", strip_tags(ob_get_clean(), "<tr><td><h2>"));
        $cat = "General";
        foreach($info_lines as $line)
        {
            // new cat?
            preg_match("~<h2>(.*)</h2>~", $line, $title) ? $cat = $title[1] : null;
            if(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val))
            {
                $info_arr[$cat][$val[1]] = $val[2];
            }
            elseif(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val))
            {
                $info_arr[$cat][$val[1]] = array("local" => $val[2], "master" => $val[3]);
            }
        }
        return $info_arr;
    }
}
