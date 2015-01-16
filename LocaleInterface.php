<?php

namespace FDevs\Locale;


interface LocaleInterface
{
    /**
     * is Locale
     *
     * @param string $locale
     *
     * @return boolean
     */
    public function isLocale($locale);

    /**
     * get Locale
     *
     * @return string
     */
    public function getLocale();

    /**
     * set Locale
     *
     * @param string $locale
     *
     * @return self
     */
    public function setLocale($locale);
}
