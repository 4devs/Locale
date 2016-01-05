<?php

namespace FDevs\Locale\Tests;

use FDevs\Locale\TranslatorInterface;

abstract class AbstractTranslatorTest extends AbstractTest
{
    /**
     * @return TranslatorInterface
     */
    abstract protected function createTranslator();

    /**
     * test interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf('FDevs\Locale\TranslatorInterface', $this->createTranslator());
    }

    /**
     * test trans exception.
     */
    public function testTransException()
    {
        $this->setExpectedException('FDevs\Locale\Exception\InvalidLocaleException');
        $this->createTranslator()->trans([], 'uk net');
    }

    /**
     * test set locale exception.
     */
    public function testSetLocaleException()
    {
        $trans = $this->createTranslator();
        $this->setExpectedException('FDevs\Locale\Exception\InvalidLocaleException');
        $trans->setLocale('uk net');
    }

    /**
     * @dataProvider transProvider
     */
    public function testTrans($data, $locale, $expected)
    {
        $text = $this->createTranslator()->trans($data, $locale);
        $this->assertLocale($text, $expected);
    }

    /**
     * @dataProvider transProvider
     */
    public function testSetLocale($data, $locale, $expected)
    {
        $trans = $this->createTranslator();
        $trans->setLocale($locale);
        $text = $trans->trans($data);
        $this->assertLocale($text, $expected);
    }

    /**
     * trans provider.
     *
     * @return array
     */
    public function transProvider()
    {
        return [
            [
                [
                    $this->createLocaleMock('en'),
                    $this->createLocaleMock('ru'),
                    $this->createLocaleMock('uk'),
                ],
                'ru',
                'ru',
            ],
            [
                [
                    $this->createLocaleMock('en'),
                    $this->createLocaleMock('ru'),
                    $this->createLocaleMock('uk'),
                ],
                '',
                'en',
            ],
            [
                [
                    $this->createLocaleMock('en'),
                    $this->createLocaleMock('ru'),
                    $this->createLocaleMock('uk'),
                ],
                'rus',
                null,
            ],
            [
                [
                    $this->createLocaleMock('en'),
                ],
                'ru',
                null,
            ],
        ];
    }

    /**
     * @param mixed       $model
     * @param string|null $locale
     */
    protected function assertLocale($model, $locale)
    {
        if ($locale === null) {
            $this->assertNull($model);
        } else {
            $this->assertInstanceOf('FDevs\Locale\LocaleInterface', $model);
            $this->assertEquals($model->getLocale(), $locale);
        }
    }
}
