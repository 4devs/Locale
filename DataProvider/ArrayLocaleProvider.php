<?php

namespace FDevs\Locale\DataProvider;

use FDevs\Locale\LocaleInterface;

class ArrayLocaleProvider extends AbstractChoiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getFirst($data)
    {
        return reset($data) ?: null;
    }

    /**
     * {@inheritdoc}
     */
    protected function has($data)
    {
        return (bool) count($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function getByLocale($data, $locale)
    {
        return array_filter($data, function (LocaleInterface $var) use ($locale) {
            return $var->isLocale($locale);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function support($data)
    {
        return is_array($data) && reset($data) instanceof LocaleInterface;
    }
}
