<?php

class DataCollector implements \Fabfuel\Prophiler\DataCollectorInterface
{
    /**
     * Get the title of this data collector
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Lorem Ipsum';
    }

    /**
     * Get the bootstrap icon class
     *
     * @return string
     */
    public function getIcon()
    {
        return 'cog';
    }

    /**
     * Get data from the data collector
     *
     * @return array
     */
    public function getData()
    {
        return [
            'lorem' => 'ipsum',
            'foobar' => [
                'test1' => 'AB',
                'test2' => 55,
                'test3' => 12.4,
                'test4' => true,
            ],
        ];
    }
}
