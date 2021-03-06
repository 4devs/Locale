<?php

namespace FDevs\Locale\Model;

use FDevs\Locale\Util\LocaleValidate;

class PriorityLocale
{
    /** @var string */
    private $locale;

    /** @var array */
    private $localeList = [];

    /**
     * PriorityLocale constructor.
     *
     * @param string $locale
     * @param array  $localeList
     */
    public function __construct($locale = 'en', array $localeList = [])
    {
        $this->setLocale($locale);
        $this->setLocaleList($localeList);
    }

    /**
     * get locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * set locale.
     *
     * @param string $locale
     *
     * @return self
     */
    public function setLocale($locale)
    {
        $this->locale = LocaleValidate::assertValidLocale($locale);

        return $this;
    }

    /**
     * get locale list.
     *
     * @return array
     */
    public function getLocaleList()
    {
        return $this->localeList;
    }

    /**
     * set locale list.
     *
     * @param array $localeList
     *
     * @return self
     */
    public function setLocaleList(array $localeList)
    {
        $this->localeList = [];
        foreach ($localeList as $locale) {
            $this->localeList[] = LocaleValidate::assertValidLocale($locale);
        }

        return $this;
    }
}
