<?php

namespace FDevs\Locale;

use FDevs\Locale\Exception\InvalidArgumentException;
use FDevs\Locale\Util\ChoiceText;

class Translator implements TranslatorInterface
{
    /** @var string */
    private $locale;

    /** @var array */
    private $priorityLocaleList = [];

    /** @var bool */
    private $returnFirst = true;

    /**
     * init
     *
     * @param string $locale
     * @param array  $priorityLocaleList
     * @param bool   $returnFirst
     */
    public function __construct($locale, array $priorityLocaleList = [], $returnFirst = true)
    {
        $this->setLocale($locale);
        $this->setPriorityLocaleList($priorityLocaleList);
        $this->returnFirst = $returnFirst;
    }

    /**
     * return first if empty locale data
     *
     * @param boolean $returnFirst
     *
     * @return $this
     */
    public function setReturnFirst($returnFirst)
    {
        $this->returnFirst = $returnFirst;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function trans($data, $locale = '')
    {
        if ($locale) {
            $this->assertValidLocale($locale);
        }
        $result = ChoiceText::getText($data, $locale ?: $this->locale);

        if (!$result && $this->returnFirst) {
            $result = ChoiceText::getFirstText($data);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function transChoice($data, $locale = '', array $priorityLocale = [])
    {
        if ($locale) {
            $this->assertValidLocale($locale);
        } else {
            $locale = $this->locale;
        }

        if (count($priorityLocale)) {
            $this->assertValidPriorityLocale($priorityLocale);
            array_unshift($priorityLocale, $locale);
        } elseif (isset($this->priorityLocaleList[$locale])) {
            $priorityLocale = [$locale] + $this->priorityLocaleList[$locale];
        } else {
            $priorityLocale = [$locale];
        }

        $result = ChoiceText::getTextByPriority($data, $priorityLocale);

        if (!$result && $this->returnFirst) {
            $result = ChoiceText::getFirstText($data);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function setLocale($locale)
    {
        $this->assertValidLocale($locale);
        $this->locale = $locale;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritDoc}
     */
    public function addPriorityLocale($locale, array $priorityList)
    {
        $this->assertValidLocale($locale);
        $this->assertValidPriorityLocale($priorityList);
        $this->priorityLocaleList[$locale] = $priorityList;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setPriorityLocaleList(array $priorityLocaleList)
    {
        foreach ($priorityLocaleList as $locale => $priorityLocale) {
            $this->addPriorityLocale($locale, $priorityLocale);
        }

        return $this;
    }

    /**
     * Asserts that the locale is valid, throws an Exception if not.
     *
     * @param string $locale Locale to tests
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     *
     * @return string
     */
    private function assertValidLocale($locale)
    {
        if (1 !== preg_match('/^[a-z0-9@_\\.\\-]*$/i', $locale)) {
            throw new InvalidArgumentException(sprintf('Invalid "%s" locale.', $locale));
        }

        return $locale;
    }

    /**
     * Asserts that the locale list is valid, throws an Exception if not.
     *
     * @param array $localeList Locale to tests
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     *
     * @return array
     */
    private function assertValidPriorityLocale(array $localeList)
    {
        foreach ($localeList as $locale) {
            $this->assertValidLocale($locale);
        }

        return $localeList;
    }
}
