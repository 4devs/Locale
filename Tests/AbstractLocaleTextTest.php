<?php

namespace FDevs\Locale\Tests;

use FDevs\Locale\LocaleTextInterface;

abstract class AbstractLocaleTextTest extends AbstractLocaleTest
{
    /**
     * test interface.
     */
    public function testLocaleTextInterface()
    {
        $locale = $this->createLocale();
        $this->assertInstanceOf(LocaleTextInterface::class, $locale);
    }

    /**
     * @dataProvider localeText
     */
    public function testText($text, $expected)
    {
        /** @var LocaleTextInterface $dataLocale */
        $dataLocale = $this->createLocale();
        $dataLocale->setText($text);
        $this->assertEquals($expected, $dataLocale->getText());
        $this->assertEquals($expected, strval($dataLocale));
        $this->assertEquals($expected, (string) $dataLocale);
    }

    /**
     * @return string[][]
     */
    public function localeText()
    {
        return [
            ['some en text', 'some en text'],
            ['some ru text', 'some ru text'],
            ['some uk text', 'some uk text'],
        ];
    }
}
