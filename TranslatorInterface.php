<?php

namespace FDevs\Locale;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\Exception\InvalidArgumentException;

interface TranslatorInterface
{
    /**
     * Translates the given Locale Data.
     *
     * @param array|Collection $data
     * @param string           $locale
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     *
     * @return string
     */
    public function trans($data, $locale = '');

    /**
     * Translates the given Locale Data by choosing a translation according priority Locale.
     *
     * @param array|Collection $data
     * @param string           $locale
     * @param array            $priorityLocale
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     *
     * @return string
     */
    public function transChoice($data, $locale = '', array $priorityLocale = []);

    /**
     * set default locale
     *
     * @param string $locale
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     *
     * @return self
     */
    public function setLocale($locale);

    /**
     * get locale
     *
     * @return string
     */
    public function getLocale();

    /**
     * @param string $locale
     * @param array  $priorityList
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     *
     * @return self
     */
    public function addPriorityLocale($locale, array $priorityList);

    /**
     * @param array $priorityLocaleList
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     *
     * @return self
     */
    public function setPriorityLocaleList(array $priorityLocaleList);
}
