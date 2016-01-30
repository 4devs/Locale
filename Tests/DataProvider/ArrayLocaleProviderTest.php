<?php

namespace FDevs\Locale\Tests\DataProvider;

use Doctrine\Common\Collections\ArrayCollection;
use FDevs\Locale\DataProvider\ArrayLocaleProvider;
use FDevs\Locale\Model\LocaleText;

class ArrayLocaleProviderTest extends AbstractProviderTest
{
    /**
     * {@inheritdoc}
     */
    protected function createProvider()
    {
        return new ArrayLocaleProvider();
    }

    /**
     * {@inheritdoc}
     */
    public function findProvider()
    {
        $localeRu = new LocaleText('', 'ru');
        $localeEn = new LocaleText('', 'en');
        $localeUk = new LocaleText('', 'uk');

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
        $localeRu = new LocaleText('', 'ru');

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
