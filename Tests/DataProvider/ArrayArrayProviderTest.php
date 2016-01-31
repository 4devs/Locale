<?php

namespace FDevs\Locale\Tests\DataProvider;

use Doctrine\Common\Collections\ArrayCollection;
use FDevs\Locale\DataProvider\ArrayArrayProvider;

class ArrayArrayProviderTest extends AbstractProviderTest
{
    /**
     * {@inheritdoc}
     */
    protected function createProvider()
    {
        return new ArrayArrayProvider();
    }

    /**
     * {@inheritdoc}
     */
    public function findProvider()
    {
        $localeRu = ['locale' => 'ru'];
        $localeEn = ['locale' => 'en'];
        $localeUk = ['locale' => 'uk'];

        return [
            [
                [$localeRu],
                ['ru'],
                $localeRu,
            ],
            [
                [$localeRu, $localeEn, $localeUk],
                ['ru'],
                $localeRu,
            ],
            [
                [$localeRu, $localeEn, $localeUk],
                ['es', 'ru'],
                $localeRu,
            ],
            [
                [$localeRu, $localeEn, $localeUk],
                ['en', 'ru'],
                $localeEn,
            ],
            [
                [$localeRu, $localeEn, $localeUk],
                ['rus'],
                null,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportProvider()
    {
        $localeRu = ['locale' => 'ru'];

        return [
            [
                [$localeRu],
                true,
            ],
            [
                [$localeRu, $localeRu, $localeRu],
                true,
            ],
            [
                new ArrayCollection([[]]),
                false,
            ],
            [
                [[]],
                false,
            ],
            [
                new \SplObjectStorage(),
                false,
            ],
        ];
    }
}
