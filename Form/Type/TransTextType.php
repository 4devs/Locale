<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransTextType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return 'trans_text';
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return TransType::class;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['locale_type' => LocaleTextType::class]);
    }
}
