<?php

namespace FDevs\Locale\DataProvider;

abstract class AbstractChoiceProvider implements DataProviderInterface
{
    /**
     * @param mixed $data
     *
     * @return mixed
     */
    abstract protected function getFirst($data);

    /**
     * @param mixed $data
     *
     * @return bool
     */
    abstract protected function has($data);

    /**
     * @param mixed  $data
     * @param string $locale
     *
     * @return mixed
     */
    abstract protected function getByLocale($data, $locale);

    /**
     * {@inheritdoc}
     */
    public function find($data, array $localeList)
    {
        $localeData = null;
        foreach ($localeList as $locale) {
            $localeData = $this->getByLocale($data, $locale);
            if ($this->has($localeData)) {
                break;
            }
        }

        return $this->getFirst($localeData);
    }
}
