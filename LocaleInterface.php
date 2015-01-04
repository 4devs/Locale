<?php

namespace FDevs\Locale;

use Doctrine\Common\Collections\Collection;

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

    /**
     * add self locale to collection
     *
     * @param Collection $collection
     *
     * @return Collection
     */
    public function addLocaleToCollection(Collection $collection);
}
