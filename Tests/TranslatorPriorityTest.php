<?php

namespace FDevs\Locale\Tests;

use FDevs\Locale\TranslatorPriority;

class TranslatorPriorityTest extends AbstractTranslatorTest
{
    /**
     * test add priority Locale.
     */
    public function testAddPriorityLocale()
    {
        $trans = $this->createTranslator();
        $priorityLocale = $this->createPriorityLocaleMock('uk', ['ru']);
        $trans->addPriorityLocale($priorityLocale);

        $priorityLocale = $this->createPriorityLocaleMock('ru', ['en', 'uk']);
        $trans->addPriorityLocale($priorityLocale);
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
                    $this->createLocaleMock('ru'),
                    $this->createLocaleMock('uk'),
                ],
                'en',
                'uk',
            ],
            [
                [
                    $this->createLocaleMock('en'),
                ],
                'ru',
                'en',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslator()
    {
        $priorityLocale = [
            $this->createPriorityLocaleMock('ru', ['ru', 'en']),
            $this->createPriorityLocaleMock('uk', ['uk', 'ru']),
            $this->createPriorityLocaleMock('en', ['uk']),
        ];

        return new TranslatorPriority('en', $priorityLocale);
    }
}
