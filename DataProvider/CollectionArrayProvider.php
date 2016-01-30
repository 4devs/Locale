<?php

namespace FDevs\Locale\DataProvider;

use Doctrine\Common\Collections\Collection;

class CollectionArrayProvider extends CollectionLocaleProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getByLocale($data, $locale)
    {
        return $data->filter(function (array $var) use ($locale) {
            return $var['locale'] === $locale;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function support($data)
    {
        $status = $data instanceof Collection;
        if ($status) {
            $first = $data->first();
            $status = is_array($first) && !empty($first['locale']);
        }

        return $status;
    }
}
