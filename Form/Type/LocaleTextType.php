<?php
namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'FDevs\Locale\Model\LocaleText',
            'type'       => 'text',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'fdevs_locale';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_locale_text';
    }
}
