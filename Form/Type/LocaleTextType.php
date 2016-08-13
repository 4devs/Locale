<?php
namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocaleTextType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', $options['type'], $options['options']);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined(['type'])
            ->addAllowedTypes('type', ['string', '\Symfony\Component\Form\FormTypeInterface'])
            ->setDefaults(['data_class' => 'FDevs\Locale\Model\LocaleText', 'type' => TextType::class])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return LocaleType::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return 'fdevs_locale_text';
    }
}
