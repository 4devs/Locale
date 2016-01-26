<?php

namespace FDevs\Locale\Tests\Form\Type;

use FDevs\Locale\Form\Type\TransTextType;

class TransTextTypeTest extends AbstractTransTypeTest
{
    /**
     * {@inheritdoc}
     */
    protected function getFormType()
    {
        return TransTextType::class;
    }
}
