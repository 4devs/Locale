<?php

namespace FDevs\Locale\Tests\DataProvider;

use FDevs\Locale\Tests\AbstractTest;
use FDevs\Locale\DataProvider\DataProviderInterface;

abstract class AbstractProviderTest extends AbstractTest
{
    /**
     * @return array
     */
    abstract public function findProvider();

    /**
     * @return array
     */
    abstract public function supportProvider();

    /**
     * @return DataProviderInterface
     */
    abstract protected function createProvider();

    /**
     * test interface.
     */
    public function testInterface()
    {
        $provider = $this->createProvider();
        $this->assertInstanceOf(DataProviderInterface::class, $provider);
    }

    /**
     * @dataProvider findProvider
     */
    public function testFind($data, $localeList, $expected)
    {
        $provider = $this->createProvider();
        $result = $provider->find($data, $localeList);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider supportProvider
     */
    public function testSupport($data, $expected)
    {
        $provider = $this->createProvider();
        $result = $provider->support($data);
        $this->assertEquals($expected, $result);
    }
}
