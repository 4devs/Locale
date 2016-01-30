<?php

namespace FDevs\Locale\DataProvider;

interface DataProviderInterface
{
    /**
     * @param mixed $data
     * @param array $localeList
     *
     * @return mixed
     */
    public function find($data, array $localeList);

    /**
     * @param $data
     *
     * @return bool
     */
    public function support($data);
}
