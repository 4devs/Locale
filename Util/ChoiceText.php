<?php

namespace FDevs\Locale\Util;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\LocaleTextInterface;
use FDevs\Locale\Model\LocaleText;

class ChoiceText
{
    /** @var  string */
    private static $defaultLocale;

    /**
     * set Locale
     *
     * @param string $locale
     *
     * @return $this
     */
    public static function setDefaultLocale($locale)
    {
        self::$defaultLocale = $locale;
    }

    /**
     * @param array|Collection $data
     * @param string           $locale
     *
     * @return string
     */
    public static function getText($data, $locale = '')
    {
        $result = '';
        $locale = self::ensureLocale($locale);
        if ($data instanceof Collection) {
            $result = self::getTextByCollection($data, $locale);
        } elseif (is_array($data)) {
            $result = self::getTextByArray($data, $locale);
        }

        return $result;
    }

    /**
     * get Text By Priority Locale
     *
     * @param array|Collection $data
     * @param array            $localeList
     *
     * @return string
     */
    public static function getTextByPriority($data, array $localeList)
    {
        $result = '';
        if ($data instanceof Collection) {
            $callable = function ($data, $locale) {
                return self::getTextByCollection($data, $locale);
            };
        } elseif (is_array($data)) {
            $callable = function ($data, $locale) {
                return self::getTextByArray($data, $locale);
            };
        } else {
            $callable = function ($data, $locale) {
                return self::getFirstText($data);
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
     * get Text By Collection
     *
     * @param Collection $data
     * @param string     $locale
     *
     * @return string
     */
    public static function getTextByCollection(Collection $data, $locale = '')
    {
        $result = '';
        $locale = self::ensureLocale($locale);
        $text = $data->filter(
            function (LocaleTextInterface $var) use ($locale) {
                return $var->isLocale($locale);
            }
        );
        if (count($text)) {
            $result = self::getFirstText($text);
        }

        return $result;
    }

    /**
     * get First Text
     *
     * @param Collection|array $data
     *
     * @return string
     */
    public static function getFirstText($data)
    {
        $locale = ['text' => ''];
        if ($data instanceof Collection) {
            $locale = $data->first();
        } elseif (is_array($data)) {
            $locale = reset($data);
        }

        return $locale instanceof LocaleText ? $locale->getText() : (is_array($locale) ? $locale['text'] : '');
    }

    /**
     * get Text By Array
     *
     * @param array  $data
     * @param string $locale
     *
     * @return string
     */
    public static function getTextByArray(array $data, $locale = '')
    {
        $result = '';
        $locale = self::ensureLocale($locale);
        $text = array_filter(
            $data,
            function (LocaleTextInterface $var) use ($locale) {
                return $var->isLocale($locale);
            }
        );
        if (count($text)) {
            $result = self::getFirstText($text);
        }

        return $result;
    }

    /**
     * get Locale
     *
     * @param string $locale
     *
     * @return string
     */
    protected static function ensureLocale($locale = '')
    {
        return $locale ?: self::$defaultLocale;
    }
}
