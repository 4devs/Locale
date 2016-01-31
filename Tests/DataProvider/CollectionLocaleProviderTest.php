<?php

namespace FDevs\Locale\Tests\DataProvider;

use Doctrine\Common\Collections\ArrayCollection;
use FDevs\Locale\DataProvider\CollectionLocaleProvider;
use FDevs\Locale\Model\LocaleText;

class CollectionLocaleProviderTest extends AbstractProviderTest
{
    /**
     * {@inheritdoc}
     */
    protected function createProvider()
    {
        return new CollectionLocaleProvider();
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
                new ArrayCollection([$localeRu]),
                ['ru'],
                $localeRu,
            ],
            [
                new ArrayCollection([$localeRu, $localeEn, $localeUk]),
                ['ru'],
                $localeRu,
            ],
            [
                new ArrayCollection([$localeRu, $localeEn, $localeUk]),
                ['es', 'ru'],
                $localeRu,
            ],
            [
                new ArrayCollection([$localeRu, $localeEn, $localeUk]),
                ['en', 'ru'],
                $localeEn,
            ],
            [
                new ArrayCollection([$localeRu, $localeEn, $localeUk]),
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
                new ArrayCollection([$localeRu]),
                true,
            ],
            [
                new ArrayCollection([$localeRu, $localeRu, $localeRu]),
                true,
            ],
            [
                new ArrayCollection([[]]),
                false,
            ],
            [
                new \SplObjectStorage(),
                false,
            ],
        ];
    }
}
