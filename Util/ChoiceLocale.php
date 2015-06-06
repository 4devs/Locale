<?php

namespace FDevs\Locale\Util;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\LocaleInterface;

class ChoiceLocale
{
    /**
     * get locale by array
     *
     * @param array|LocaleInterface[] $data
     * @param string                  $locale
     *
     * @return LocaleInterface|null
     */
    public static function getByArray(array $data, $locale)
    {
        $locale = array_filter($data, function (LocaleInterface $var) use ($locale) {
            return $var->isLocale($locale);
        });

        return self::getFirst($locale);
    }

    /**
     * @param Collection|LocaleInterface[] $data
     * @param string                       $locale
     *
     * @return LocaleInterface|null
     */
    public static function getByCollection(Collection $data, $locale)
    {
        $locale = $data->filter(function (LocaleInterface $var) use ($locale) {
            return $var->isLocale($locale);
        });

        return self::getFirst($locale);

    }

    /**
     * @param array|Collection|LocaleInterface[] $data
     * @param array                              $localeList
     * @param bool                               $returnFirst
     *
     * @return LocaleInterface|null
     */
    public static function getByPriority($data, array $localeList, $returnFirst = true)
    {
        $result = null;
        if ($data instanceof Collection) {
            $callable = function ($data, $locale) {
                return self::getByCollection($data, $locale);
            };
        } elseif (is_array($data)) {
            $callable = function ($data, $locale) {
                return self::getByArray($data, $locale);
            };
        } elseif ($returnFirst) {
            $callable = function ($data, $locale) {
                return self::getFirst($data);
            };
        } else {
            $callable = function ($data, $locale) {
                return '';
            };
        }

        foreach ($localeList as $locale) {
            $result = $callable($data, $locale);
            if ($result) {
                break;
            }
        }

        return $result;

    }

    /**
     * get locale
     *
     * @param array|Collection|LocaleInterface[] $data
     * @param string                             $locale
     *
     * @return LocaleInterface|null
     */
    public static function get($data, $locale)
    {
        $result = null;
        if ($data instanceof Collection) {
            $result = self::getByCollection($data, $locale);
        } elseif (is_array($data)) {
            $result = self::getByArray($data, $locale);
        }

        return $result;
    }

    /**
     * get first
     *
     * @param array|Collection|LocaleInterface[] $data
     *
     * @return LocaleInterface|null
     */
    public static function getFirst($data)
    {
        $locale = null;
        if ($data instanceof Collection && $data->count()) {
            $locale = $data->first();
        } elseif (is_array($data) && count($data)) {
            $locale = reset($data);
        }

        return $locale;
    }
}
