<?php

namespace FDevs\Locale\Util;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\LocaleInterface;

class ChoiceLocale
{
    /**
     * get by priority.
     *
     * @param array|Collection|LocaleInterface[] $data
     * @param array                              $localeList
     *
     * @return LocaleInterface|null
     */
    public static function getByPriority($data, array $localeList)
    {
        $result = null;
        $callable = null;
        if ($data instanceof Collection) {
            $callable = function ($data, $locale) {
                return self::getByCollection($data, $locale);
            };
        } elseif (is_array($data)) {
            $callable = function ($data, $locale) {
                return self::getByArray($data, $locale);
            };
        }

        if ($callable) {
            foreach ($localeList as $locale) {
                $result = $callable($data, $locale);
                if ($result) {
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * get locale.
     *
     * @param array|Collection|LocaleInterface[] $data
     * @param string                             $locale
     *
     * @return LocaleInterface|null
     */
    public static function get($data, $locale)
    {
        return self::getByPriority($data, [$locale]);
    }

    /**
     * get first.
     *
     * @param array|Collection|LocaleInterface[] $data
     *
     * @return LocaleInterface|null
     */
    private static function getFirst($data)
    {
        $locale = null;
        if ($data instanceof Collection && $data->count()) {
            $locale = $data->first();
        } elseif (is_array($data) && count($data)) {
            $locale = reset($data);
        }

        return $locale;
    }

    /**
     * get locale by array.
     *
     * @param array|LocaleInterface[] $data
     * @param string                  $locale
     *
     * @return LocaleInterface|null
     */
    private static function getByArray(array $data, $locale)
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
    private static function getByCollection(Collection $data, $locale)
    {
        $locale = $data->filter(function (LocaleInterface $var) use ($locale) {
            return $var->isLocale($locale);
        });

        return self::getFirst($locale);
    }
}
