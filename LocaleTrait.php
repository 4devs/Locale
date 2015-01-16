<?php

namespace FDevs\Locale;

trait LocaleTrait
{
    /** @var string */
    protected $locale;

    /**
     * @param string $locale
     *
     * @return bool
     */
    public function isLocale($locale)
    {
        return $this->locale === $locale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
}
