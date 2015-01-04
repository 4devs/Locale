<?php

namespace FDevs\Locale;

use Doctrine\Common\Collections\Collection;

trait LocaleTrait
{
    /** @var string */
    protected $locale;

    /**
     * @param Collection $collection
     *
     * @return Collection
     */
    public function addLocaleToCollection(Collection $collection)
    {
        $exist = $collection->exists(function ($key, LocaleInterface $el) {
            return $el->isLocale($this->getLocale());
        });
        if (!$exist) {
            $collection->add($this);
        }

        return $collection;
    }

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
