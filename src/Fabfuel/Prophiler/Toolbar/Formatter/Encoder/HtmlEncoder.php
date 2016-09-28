<?php

namespace Fabfuel\Prophiler\Toolbar\Formatter\Encoder;

class HtmlEncoder implements EncoderInterface
{

    const ENCODER_FLAGS = ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE;

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
            ? htmlentities($encode, static::ENCODER_FLAGS, '', false)
            : $encode;
    }

}
