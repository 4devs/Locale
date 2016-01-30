<?php

namespace FDevs\Locale\DataProvider;

class ArrayArrayProvider extends ArrayLocaleProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getByLocale($data, $locale)
    {
        return array_filter($data, function (array $var) use ($locale) {
            return $var['locale'] === $locale;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function support($data)
    {
        $status = is_array($data);
        if ($status) {
            $first = reset($data);
            $status = is_array($first) && !empty($first['locale']);
        }

        return $status;
    }
}
