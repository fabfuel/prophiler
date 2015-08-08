<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 19.11.14, 07:00 
 */
namespace Fabfuel\Prophiler;

/**
 * Interface DataCollectorInterface
 * @package Fabfuel\Prophiler
 */
interface DataCollectorInterface
{
    /**
     * Get the title of this data collector
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get the icon HTML markup
     *
     * For example font-awesome icons: <i class="fa fa-pie-chart"></i>
     * See: http://fortawesome.github.io/Font-Awesome/icons/
     *
     * @return string
     */
    public function getIcon();

    /**
     * Get data from the data collector
     *
     * @return array
     */
    public function getData();
}
