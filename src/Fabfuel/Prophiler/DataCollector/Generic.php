<?php
/**
 * @author @potfur <wachowski.michal@gmail.com>
 * @created 26.02.15, 22:57
 */
namespace Fabfuel\Prophiler\DataCollector;

use Fabfuel\Prophiler\DataCollectorInterface;

class Generic implements DataCollectorInterface
{
    protected $title = 'Unnamed';
    protected $icon;
    protected $data = [];

    /**
     * Get the title of this data collector
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title for this data collector
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;
    }

    /**
     * Get the icon HTML markup
     * If icon not set - returns empty string
     *
     * For example font-awesome icons: <i class="fa fa-pie-chart"></i>
     * See: http://fortawesome.github.io/Font-Awesome/icons/
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon ? sprintf('<i class="fa %s"></i>', $this->icon) : '';
    }

    /**
     * Set icon for HTML markup
     *
     * This should be font-awesome icon eg. fa-circle-thin
     * See: http://fortawesome.github.io/Font-Awesome/icons/
     *
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = (string) $icon;
    }

    /**
     * Get data from the data collector
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data for data collector
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
}
