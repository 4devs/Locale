<?php

namespace FDevs\Locale\Form\Type;

use FDevs\Locale\Form\EventListener\TranslatableFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TranslatableType extends AbstractType
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
        return 'fdevs_translatable';
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $resizeListener = new TranslatableFormSubscriber($options['type'], $options['options'], $options['locales']);

        $builder->addEventSubscriber($resizeListener);
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(['type'])
            ->setDefaults(
                [
                    'type'         => 'text',
                    'options'      => [],
                    'block_locale' => 'inline',
                    'locales'      => $this->locales,
                ]
            )
            ->setOptional(['locales', 'options', 'block_locale'])
            ->addAllowedTypes([
                'locales'      => 'array',
                'options'      => 'array',
                'type'         => ['string', '\Symfony\Component\Form\FormTypeInterface'],
                'block_locale' => ['string'],
            ])
            ->setNormalizers(['block_locale' => function ($options, $value) {
                return 'fdevs_locale_'.$value;
            }]);
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
