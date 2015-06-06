<?php

namespace FDevs\Locale\Form\Type;

use FDevs\Locale\Form\EventListener\TranslatableFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransType extends AbstractType
{
    /**
     * @var array
     */
    private $locales = ['en'];

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'trans';
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new TranslatableFormSubscriber($options['locale_type'], $options['options'], $options['locales']));
    }

    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['block_locale'] = $options['block_locale'];
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['locale_type'])
            ->setDefaults(
                [
                    'locale_type'  => 'fdevs_locale',
                    'options'      => [],
                    'block_locale' => 'inline',
                    'locales'      => $this->locales,
                ]
            )
            ->setDefined(['locales', 'options', 'block_locale'])
            ->addAllowedTypes('locales', 'array')
            ->addAllowedTypes('options', 'array')
            ->addAllowedTypes('locale_type', ['string', '\Symfony\Component\Form\FormTypeInterface'])
            ->addAllowedTypes('block_locale', ['string'])
            ->setNormalizer('block_locale', function ($options, $value) {
                return 'fdevs_locale_'.$value;
            });
    }

    /**
     * set Locales
     *
     * @param array $locales
     *
     * @return $this
     */
    public function setLocales(array $locales)
    {
        $this->locales = $locales;

        return $this;
    }
}
