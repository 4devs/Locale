<?php

namespace FDevs\Locale\Tests;

use FDevs\Locale\LocaleInterface;
use FDevs\Locale\Model\PriorityLocale;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $class
     * @param array  $data
     *
     * @return object
     */
    public static function fromArray($class, array $data)
    {
        $normalizer = new ObjectNormalizer();

        return $normalizer->denormalize($data, $class);
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
