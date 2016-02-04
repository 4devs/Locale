<?php

namespace FDevs\Locale;

interface LocaleTextInterface extends LocaleInterface
{
    /**
     * get Text.
     *
     * @return string
     */
    public function getText();

    /**
     * get Text.
     *
     * @return string
     */
    public function __toString();
}
