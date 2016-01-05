<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransTextType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TransType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['locale_type' => LocaleTextType::class]);
    }
}
