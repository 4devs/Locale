<?php

namespace FDevs\Locale;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\DataProvider\DataProviderRegistry;
use FDevs\Locale\Model\PriorityLocale;

class TranslatorPriority extends Translator implements TranslatorInterface
{
    /** @var array|PriorityLocale[] */
    private $priorityLocaleList = [];

    /**
     * TranslatorPriority constructor.
     *
     * @param string                            $default
     * @param array|Collection|PriorityLocale[] $priorityLocale
     */
    public function __construct($default = 'en', array $priorityLocale = [], DataProviderRegistry $registry = null)
    {
        parent::__construct($default, $registry);
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
        $priorityLocale = [$locale];
        if (isset($this->priorityLocaleList[$locale])) {
            $priorityLocale = array_merge($priorityLocale, $this->priorityLocaleList[$locale]);
        }

        return $this->registry->find($data, $priorityLocale);
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
}
