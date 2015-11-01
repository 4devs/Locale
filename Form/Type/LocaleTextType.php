<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocaleTextType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', $options['type'], $options['options']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined(['type'])
            ->addAllowedTypes('type', ['string', '\Symfony\Component\Form\FormTypeInterface'])
            ->setDefaults(['data_class' => 'FDevs\Locale\Model\LocaleText', 'type' => 'text']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'fdevs_locale';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fdevs_locale_text';
    }
}
