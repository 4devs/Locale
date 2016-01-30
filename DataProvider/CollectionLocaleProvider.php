<?php

namespace FDevs\Locale\DataProvider;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\LocaleInterface;

class CollectionLocaleProvider extends AbstractChoiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getFirst($data)
    {
        return $data->first();
    }

    /**
     * {@inheritdoc}
     */
    protected function has($data)
    {
        return (bool) $data->count();
    }

    /**
     * {@inheritdoc}
     */
    protected function getByLocale($data, $locale)
    {
        return $data->filter(function (LocaleInterface $var) use ($locale) {
            return $var->isLocale($locale);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function support($data)
    {
        return $data instanceof Collection && $data->first() instanceof LocaleInterface;
    }
}
