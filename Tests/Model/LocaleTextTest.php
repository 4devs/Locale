<?php

namespace FDevs\Locale\Tests\Model;

use FDevs\Locale\Model\LocaleText;
use FDevs\Locale\Tests\AbstractLocaleTextTest;

class LocaleTextTest extends AbstractLocaleTextTest
{
    /**
     * {@inheritdoc}
     */
    protected function createLocale()
    {
        return new LocaleText();
    }
}
