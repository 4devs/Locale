<?php

namespace FDevs\Locale;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\Exception\InvalidLocaleException;

interface TranslatorInterface
{
    /**
     * Translates the given Locale Data.
     *
     * @param array|Collection $data
     * @param string           $locale
     *
     * @throws InvalidLocaleException If the locale contains invalid characters
     *
     * @return LocaleInterface|null
     */
    public function trans($data, $locale = '');

    /**
     * set current locale.
     *
     * @param string $locale
     *
     * @throws InvalidLocaleException If the locale contains invalid characters
     *
     * @return self
     */
    public function setLocale($locale);
}
