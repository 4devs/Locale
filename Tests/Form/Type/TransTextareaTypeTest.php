<?php

namespace FDevs\Locale\Tests\Form\Type;

use FDevs\Locale\Form\Type\TransTextareaType;

class TransTextareaTypeTest extends AbstractTransTypeTest
{
    /**
     * {@inheritdoc}
     */
    protected function getFormType()
    {
        return TransTextareaType::class;
    }
}
