<?php

namespace FDevs\Locale;

use FDevs\Locale\Exception\InvalidLocaleException;
use FDevs\Locale\Util\ChoiceLocale;
use FDevs\Locale\Util\LocaleValidate;

class Translator implements TranslatorInterface
{
    /** @var string */
    private $locale;

    /** @var string */
    private $defaultLocale;

    /**
     * init.
     *
     * @param string $defaultLocale
     */
    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = self::assertValidLocale($defaultLocale);
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
    public function getLocale()
    {
        return $this->locale ?: $this->defaultLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        $this->locale = $this->assertValidLocale($locale);

        return $this;
    }

    /**
     * @param string $locale
     *
     * @return string
     *
     * @throws InvalidLocaleException
     */
    private function assertValidLocale($locale)
    {
        return LocaleValidate::assertValidLocale($locale);
    }
}
