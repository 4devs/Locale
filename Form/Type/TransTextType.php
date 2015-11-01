<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransTextType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'trans_text';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'trans';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['locale_type' => 'fdevs_locale_text']);
    }
}
