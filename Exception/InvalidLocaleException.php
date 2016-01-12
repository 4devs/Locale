<?php

namespace FDevs\Locale\Exception;

class InvalidLocaleException extends Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct($locale, $code = 0, \ Exception $previous = null)
    {
        parent::__construct(sprintf('Invalid "%s" locale.', $locale), $code, $previous);
    }
}
