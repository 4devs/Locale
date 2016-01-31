<?php

namespace FDevs\Locale\DataProvider;

class DataProviderRegistry
{
    /** @var array|DataProviderInterface[] */
    private $list;

    /**
     * ChainProvider constructor.
     *
     * @param array|DataProviderInterface[] $list
     */
    public function __construct(array $list = [])
    {
        foreach ($list as $item) {
            $this->addProvider($item);
        }
    }

    /**
     * @param DataProviderInterface $provider
     */
    public function addProvider(DataProviderInterface $provider)
    {
        $this->list[] = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function find($data, array $localeList)
    {
        $result = null;
        foreach ($this->list as $item) {
            if ($item->support($data)) {
                $result = $item->find($data, $localeList);
                break;
            }
        }

        return $result;
    }
}
