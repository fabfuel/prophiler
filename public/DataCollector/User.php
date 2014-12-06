<?php

namespace Fabfuel\Prophiler\Demo\DataCollector;

class User implements \Fabfuel\Prophiler\DataCollectorInterface
{
    /**
     * Get the title of this data collector
     *
     * @return string
     */
    public function getTitle()
    {
        return 'User';
    }

    /**
     * Get the icon HTML markup
     *
     * For example font-awesome icons: <i class="fa fa-pie-chart"></i>
     * See: http://fortawesome.github.io/Font-Awesome/icons/
     *
     * @return string
     */
    public function getIcon()
    {
        return '<i class="fa fa-user"></i>';
    }

    /**
     * Get data from the data collector
     *
     * @return array
     */
    public function getData()
    {
        $_SESSION = [
            'test1' => 'AB',
            'test2' => 55,
            'test3' => 12.4,
            'test4' => true,
        ];

        return [
            'email' => 'john@doe.com',
            'name' => 'John Doe',
            'role' => 'Admin',
            'logged in' => (new \DateTime())->format('c'),
            'session' => $_SESSION,
        ];
    }
}
