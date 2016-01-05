<?php

namespace FDevs\Locale\Tests;

use FDevs\Locale\Translator;

class TranslatorTest extends AbstractTranslatorTest
{
    /**
     * test locale.
     */
    public function testGetLocale()
    {
        $trans = $this->createTranslator();
        $this->assertEquals('en', $trans->getLocale());

        $trans = $this->createTranslator();
        $trans->setLocale('ru');
        $this->assertEquals('ru', $trans->getLocale());
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslator()
    {
        return new Translator('en');
    }
}
