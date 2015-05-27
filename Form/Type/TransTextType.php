<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransTextType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'trans_text';
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'type'        => 'text',
                    'locale_type' => 'fdevs_locale_text',
                ]
            );
    }
}
