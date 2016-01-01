<?php

namespace FDevs\Locale\Tests;

class TranslatorTest extends AbstractTest
{
    /**
     * test locale.
     */
    public function testLocale()
    {
        $trans = $this->createTranslation();
        $this->assertEquals('en', $trans->getLocale());

        $trans = $this->createTranslation();
        $trans->setLocale('ru');
        $this->assertEquals('ru', $trans->getLocale());

        $trans = $this->createTranslation();
        $this->setExpectedException('FDevs\Locale\Exception\InvalidLocaleException');
        $trans->setLocale('uk net');
    }

    /**
     * test trans.
     */
    public function testTrans()
    {
        $data = [$this->createLocaleMock('en')];
        $text = $this->createTranslation()->trans($data);
        $this->assertLocale($text, 'en');

        $trans = $this->createTranslation()->setLocale('ru');
        $text = $trans->trans($data);
        $this->assertNull($text);

        $data[] = $this->createLocaleMock('ru');
        $trans = $this->createTranslation()->setLocale('ru');
        $text = $trans->trans($data);
        $this->assertLocale($text, 'ru');

        $trans = $this->createTranslation()->setLocale('ru');
        $text = $trans->trans($data, 'en');
        $this->assertLocale($text, 'en');
        $text = $trans->trans($data, 'ru');
        $this->assertLocale($text, 'ru');
        $text = $trans->trans($data, 'rus');
        $this->assertNull($text);

        $this->setExpectedException('FDevs\Locale\Exception\InvalidLocaleException');
        $this->createTranslation()->trans($data, 'uk net');
    }

    /**
     * test trans choice.
     */
    public function testTransChoice()
    {
        $data = [$this->createLocaleMock('en')];
        $text = $this->createTranslation()->transChoice($data);
        $this->assertLocale($text, 'en');

        $trans = $this->createTranslation()->setLocale('ru');
        $text = $trans->transChoice($data);
        $this->assertNull($text);

        $data[] = $this->createLocaleMock('ru');
        $trans = $this->createTranslation()->setLocale('ru');
        $text = $trans->transChoice($data);
        $this->assertLocale($text, 'ru');

        $trans = $this->createTranslation()->setLocale('ru');
        $text = $trans->transChoice($data, 'en');
        $this->assertLocale($text, 'en');
        $text = $trans->transChoice($data, 'ru');
        $this->assertLocale($text, 'ru');
        $text = $trans->transChoice($data, 'rus');
        $this->assertNull($text);

        $trans = $this->createTranslation();
        $text = $trans->transChoice($data, 'uk');
        $this->assertNull($text);
        $text = $trans->transChoice($data, 'uk', ['ru', 'en']);
        $this->assertLocale($text, 'ru');
        $text = $trans->transChoice($data, 'en', ['ru', 'uk']);
        $this->assertLocale($text, 'en');
        $text = $trans->transChoice($data, '', ['ru', 'uk']);
        $this->assertLocale($text, 'ru');

        $trans = $this->createTranslation('en', [
            $this->createPriorityLocaleMock('ru', ['ru', 'en']),
            $this->createPriorityLocaleMock('uk', ['uk', 'ru']),
        ]);
        $text = $trans->transChoice($data, 'uk');
        $this->assertLocale($text, 'ru');
        $text = $trans->transChoice($data, 'ru');
        $this->assertLocale($text, 'ru');
        $text = $trans->transChoice($data);
        $this->assertLocale($text, 'en');
        $text = $trans->transChoice($data, '', ['ru']);
        $this->assertLocale($text, 'ru');

        $this->setExpectedException('FDevs\Locale\Exception\InvalidLocaleException');
        $this->createTranslation()->transChoice($data, 'uk net');
    }

    /**
     * test get priority Locale
     */
    public function testGetPriorityLocale()
    {
        $trans = $this->createTranslation();
        $locale = $trans->getPriorityLocale();
        $this->assertInternalType('array', $locale);
        $this->assertCount(1, $locale);
    }

    /**
     * test add priority Locale
     */
    public function testAddPriorityLocale()
    {
        $trans = $this->createTranslation();
        $priorityLocale = $this->createPriorityLocaleMock('uk', ['ru']);
        $trans->addPriorityLocale($priorityLocale);
        $locale = $trans->getPriorityLocale('uk');
        $this->assertCount(2, $locale);

        $priorityLocale = $this->createPriorityLocaleMock('ru', ['en', 'uk']);
        $trans->addPriorityLocale($priorityLocale);
        $locale = $trans->getPriorityLocale('ru');
        $this->assertCount(3, $locale);
    }

    /**
     * @param mixed  $model
     * @param string $locale
     */
    private function assertLocale($model, $locale)
    {
        $this->assertInstanceOf('FDevs\Locale\LocaleInterface', $model);
        $this->assertEquals($model->getLocale(), $locale);
    }
}
