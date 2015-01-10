<?php

namespace FDevs\Locale\Util;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\LocaleInterface;

class CollectionLocale
{
    /**
     * add Locale to Collection
     *
     * @param Collection      $collection
     * @param LocaleInterface $locale
     *
     * @return Collection
     */
    public static function addLocaleToCollection(Collection $collection, LocaleInterface $locale)
    {
        $exist = $collection->exists(function ($key, LocaleInterface $el) use ($locale) {
            return $el->isLocale($locale->getLocale());
        });
        if (!$exist) {
            $collection->add($locale);
        }

        return $collection;
    }
}
