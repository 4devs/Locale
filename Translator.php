<?php

namespace FDevs\Locale;

use FDevs\Locale\Exception\InvalidLocaleException;
use Doctrine\Common\Collections\Collection;
use FDevs\Locale\Model\PriorityLocale;
use FDevs\Locale\Util\ChoiceLocale;

class Translator implements TranslatorInterface
{
    /** @var string */
    private $locale;

    /** @var string */
    private $defaultLocale;

    /** @var array|Collection|PriorityLocale[] */
    private $priorityLocaleList = [];

    /**
     * init.
     *
     * @param string                 $defaultLocale
     * @param array|PriorityLocale[] $priorityLocale
     */
    public function __construct($defaultLocale = 'en', $priorityLocale = [])
    {
        $this->defaultLocale = self::assertValidLocale($defaultLocale);
        foreach ($priorityLocale as $locale) {
            $this->addPriorityLocale($locale);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function trans($data, $locale = '')
    {
        $locale = $locale ? $this->assertValidLocale($locale) : $this->getLocale();

        return ChoiceLocale::get($data, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function transChoice($data, $locale = '', array $priorityLocale = [])
    {
        $locale = $locale ? $this->assertValidLocale($locale) : '';
        $priorityLocale = count($priorityLocale) ? $this->assertValidPriorityLocale($priorityLocale) : $this->getPriorityLocale($locale);
        if ($locale) {
            array_unshift($priorityLocale, $locale);
        }

        return ChoiceLocale::getByPriority($data, array_unique($priorityLocale));
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale ?: $this->defaultLocale;
    }

    /**
     * get priority locale.
     *
     * @param string $locale
     *
     * @return array
     */
    public function getPriorityLocale($locale = '')
    {
        $locale = $locale ?: $this->getLocale();
        $localeList = [];
        if (isset($this->priorityLocaleList[$locale])) {
            $localeList = $this->priorityLocaleList[$locale]->getLocaleList();
        }
        array_unshift($localeList, $locale);

        return $localeList;
    }

    /**
     * add priority locale list.
     *
     * @param PriorityLocale $priorityLocale
     *
     * @return $this
     *
     * @throws InvalidLocaleException
     */
    public function addPriorityLocale(PriorityLocale $priorityLocale)
    {
        $this->priorityLocaleList[$priorityLocale->getLocale()] = $priorityLocale;

        return $this;
    }

    /**
     * create Priority Locale.
     *
     * @param string $locale
     * @param array  $localeList
     *
     * @return PriorityLocale
     */
    public function createPriorityLocale($locale, array $localeList)
    {
        $priorityLocale = new PriorityLocale();
        $priorityLocale->setLocale($locale)->setLocaleList($localeList);

        return $priorityLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        $this->locale = self::assertValidLocale($locale);

        return $this;
    }

    /**
     * asset valid locale.
     *
     * @param string $locale
     *
     * @return string
     *
     * @throws InvalidLocaleException
     */
    public static function assertValidLocale($locale)
    {
        if (1 !== preg_match('/^[a-z0-9@_\\.\\-]*$/i', $locale)) {
            throw new InvalidLocaleException(sprintf('Invalid "%s" locale.', $locale));
        }

        return $locale;
    }

    /**
     * Asserts that the locale list is valid, throws an Exception if not.
     *
     * @param array $localeList Locale to tests
     *
     * @throws InvalidLocaleException If the locale contains invalid characters
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
