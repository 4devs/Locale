<?php

namespace FDevs\Locale\Tests;

use FDevs\Locale\LocaleInterface;
use FDevs\Locale\Translator;
use FDevs\Locale\Model\PriorityLocale;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param string $defaultLocale
     * @param array  $priorityLocale
     *
     * @return Translator
     */
    protected function createTranslation($defaultLocale = 'en', array $priorityLocale = [])
    {
        return new Translator($defaultLocale, $priorityLocale);
    }

    /**
     * @param string $locale
     *
     * @return LocaleInterface
     */
    protected function createLocaleMock($locale)
    {
        $model = $this
            ->getMockBuilder('FDevs\Locale\LocaleInterface')
            ->setMethods(['isLocale', 'getLocale', 'setLocale'])
            ->getMock()
        ;

        $model
            ->expects($this->any())
            ->method('isLocale')
            ->with($this->anything())
            ->will($this->returnCallback(function ($loc) use ($locale) {
                return $loc === $locale;
            }))
        ;

        $model
            ->method('setLocale')
            ->will($this->returnSelf())
        ;

        $model
            ->method('getLocale')
            ->willReturn($locale)
        ;

        return $model;
    }

    /**
     * @param string $locale
     * @param array  $localeList
     *
     * @return PriorityLocale
     */
    protected function createPriorityLocaleMock($locale, array $localeList = [])
    {
        $model = $this
            ->getMockBuilder('FDevs\Locale\Model\PriorityLocale')
            ->setMethods(['getLocaleList', 'setLocaleList', 'setLocale', 'getLocale'])
            ->getMock()
        ;

        $model
            ->expects($this->any())
            ->method('getLocaleList')
            ->will($this->returnValue($localeList))
        ;
        $model
            ->method('setLocaleList')
            ->will($this->returnSelf())
        ;

        $model
            ->method('setLocale')
            ->will($this->returnSelf())
        ;


        $model
            ->method('getLocale')
            ->willReturn($locale)
        ;

        return $model;
    }

}