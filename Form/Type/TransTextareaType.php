<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransTextareaType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'trans_textarea';
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'trans';
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'options'      => ['type' => 'textarea'],
                'block_locale' => 'text_tabs',
                'locale_type'  => 'fdevs_locale_text',
            ]);
    }
}
