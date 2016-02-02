<?php

namespace FDevs\Locale;

use FDevs\Locale\Exception\InvalidLocaleException;
use FDevs\Locale\DataProvider\ArrayLocaleProvider;
use FDevs\Locale\DataProvider\DataProviderRegistry;
use FDevs\Locale\DataProvider\CollectionLocaleProvider;
use FDevs\Locale\Util\LocaleValidate;

class Translator implements TranslatorInterface
{
    /** @var string */
    private $locale;

    /** @var string */
    private $defaultLocale;

    /** @var DataProviderRegistry */
    protected $registry;

    /**
     * Translator constructor.
     *
     * @param string                    $defaultLocale
     * @param DataProviderRegistry|null $registry
     */
    public function __construct($defaultLocale = 'en', DataProviderRegistry $registry = null)
    {
        $this->defaultLocale = $this->assertValidLocale($defaultLocale);
        if (!$registry) {
            $this->registry = new DataProviderRegistry([new ArrayLocaleProvider(), new CollectionLocaleProvider()]);
        } else {
            $this->registry = $registry;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function trans($data, $locale = '')
    {
        $locale = $locale ? $this->assertValidLocale($locale) : $this->getLocale();

        return $this->registry->find($data, [$locale]);
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
    protected function assertValidLocale($locale)
    {
        return LocaleValidate::assertValidLocale($locale);
    }
}
