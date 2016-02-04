<?php

namespace FDevs\Locale\Tests;

use FDevs\Locale\LocaleInterface;

abstract class AbstractLocaleTest extends AbstractTest
{
    /**
     * @return LocaleInterface
     */
    abstract protected function createLocale();

    /**
     * test interface.
     */
    public function testLocaleInterface()
    {
        $locale = $this->createLocale();
        $this->assertInstanceOf(LocaleInterface::class, $locale);
    }

    /**
     * @dataProvider localeEqualsProvider
     */
    public function testEqualsLocale($locale, $expected, $method)
    {
        $method = 'assert'.ucfirst($method);
        $dataLocale = $this->createLocale();
        $dataLocale->setLocale($locale);

        $this->{$method}($expected, $dataLocale->getLocale());
        $this->{$method}(true, $dataLocale->isLocale($expected));
    }

    /**
     * @return string[][]
     */
    public function localeEqualsProvider()
    {
        return [
            ['en', 'en', 'equals'],
            ['ru', 'ru', 'equals'],
            ['uk', 'uk', 'equals'],
            ['rus', 'ru', 'notEquals'],
            ['en', 'uk', 'notEquals'],
            ['en_US', 'en', 'notEquals'],
        ];
    }
}
