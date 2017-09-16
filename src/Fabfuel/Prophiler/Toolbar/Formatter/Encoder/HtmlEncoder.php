<?php

namespace Fabfuel\Prophiler\Toolbar\Formatter\Encoder;

class HtmlEncoder implements EncoderInterface
{

    /**
     * @var string
     */
    protected $encoding;

    /**
     * @param string $encoding
     */
    public function __construct($encoding = '')
    {
        $this->encoding = $encoding;
    }

    /**
     * @param string $encode
     *
     * @return string
     */
    public function encode($encode)
    {
        return is_string($encode)
            ? htmlentities($encode, static::getFlags(), '', false)
            : $encode;
    }

    /**
     * @return int
     */
    protected static function getFlags()
    {
        return ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE;
    }
}
