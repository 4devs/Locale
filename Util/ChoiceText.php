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
     * @param array|Collection|LocaleTextInterface[] $data
     * @param string                                 $locale
     *
     * @return string
     */
    public static function getText($data, $locale = '')
    {
        $result = ChoiceLocale::get($data, self::ensureLocale($locale));

        return self::prepareResult($result);
    }

    /**
     * get Text By Priority Locale
     *
     * @param array|Collection $data
     * @param array            $localeList
     * @param bool             $returnFirst
     *
     * @return string
     */
    public static function getTextByPriority($data, array $localeList, $returnFirst = true)
    {
        $result = ChoiceLocale::getByPriority($data, $localeList, $returnFirst);

        return self::prepareResult($result);
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
        $locale = self::ensureLocale($locale);
        $result = ChoiceLocale::getByCollection($data, $locale);

        return self::prepareResult($result);
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
        $result = ChoiceLocale::getFirst($data);

        return self::prepareResult($result);
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
        $result = ChoiceLocale::getByArray($data, self::ensureLocale($locale));

        return self::prepareResult($result);
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

    /**
     * prepare result
     *
     * @param LocaleTextInterface|null $result
     *
     * @return string
     */
    protected static function prepareResult(LocaleTextInterface $result = null)
    {
        return $result instanceof LocaleTextInterface ? $result->getText() : '';
    }
}
