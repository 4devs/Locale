<?php

namespace FDevs\Locale;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\Util\ChoiceLocale;
use FDevs\Locale\Util\LocaleValidate;
use FDevs\Locale\Model\PriorityLocale;

class TranslatorPriority implements TranslatorInterface
{
    /** @var string */
    private $locale;

    /** @var string */
    private $defaultLocale;

    /** @var array|PriorityLocale[] */
    private $priorityLocaleList = [];

    /**
     * TranslatorPriority constructor.
     *
     * @param string                            $defaultLocale
     * @param array|Collection|PriorityLocale[] $priorityLocale
     */
    public function __construct($defaultLocale = 'en', array $priorityLocale = [])
    {
        $this->defaultLocale = $this->assertValidLocale($defaultLocale);
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
        if ($locale && isset($this->priorityLocaleList[$locale])) {
            $priorityLocale = array_merge([$locale], $this->priorityLocaleList[$locale]);
        } else {
            $priorityLocale[] = $locale;
        }

        return ChoiceLocale::getByPriority($data, array_unique($priorityLocale));
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
     * @return string
     */
    public function getLocale()
    {
        return $this->locale ?: $this->defaultLocale;
    }

    /**
     * @param PriorityLocale $locale
     *
     * @return $this
     */
    public function addPriorityLocale(PriorityLocale $locale)
    {
        $this->priorityLocaleList[$locale->getLocale()] = $locale->getLocaleList();

        return $this;
    }

    /**
     * @param string $locale
     *
     * @return string
     *
     * @throws Exception\InvalidLocaleException
     */
    private function assertValidLocale($locale)
    {
        return LocaleValidate::assertValidLocale($locale);
    }
}
