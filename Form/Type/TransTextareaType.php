<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransTextareaType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return 'trans_textarea';
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
        $resolver
            ->setDefaults([
                'options'      => ['type' => TextareaType::class],
                'block_locale' => 'text_tabs',
                'locale_type'  => LocaleTextType::class,
            ]);
    }
}
