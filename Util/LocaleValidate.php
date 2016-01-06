<?php

namespace FDevs\Locale\Util;

use FDevs\Locale\Exception\InvalidLocaleException;

class LocaleValidate
{
    /**
     * asset valid locale.
     *
     * @param string $locale
     *
     * @return string
     *
     * @throws InvalidLocaleException
     */
    public static function assertValidLocale($locale)
    {
        if (1 !== preg_match('/^[a-z0-9@_\\.\\-]*$/i', $locale)) {
            throw new InvalidLocaleException($locale);
        }

        return $locale;
    }
}
