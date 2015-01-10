<?php

namespace FDevs\Locale\Form\Type;

use FDevs\Locale\Form\EventListener\TranslatableFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
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
        $type = $options['type'];
        $localeOptions = $this->prepareOptions($options['options'], $options);
        $resizeListener = new TranslatableFormSubscriber($type, $localeOptions, $options['locales']);

        $builder->addEventSubscriber($resizeListener);
    }

    /**
     * {@inheritDoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        parent::finishView($view, $form, $options);
        $view->vars['type'] = $options['type'];
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
                    'type' => 'text',
                    'options' => [
                        'trim' => true,
                        'required' => true,
                        'read_only' => false,
                        'max_length' => null,
                        'pattern' => null,
                        'mapped' => true,
                        'by_reference' => true,
                        'label_attr' => [],
                    ],
                    'locales' => $this->locales,
                ]
            )
            ->addAllowedValues(['type' => ['text', 'textarea']])
            ->setOptional(['locales'])
            ->addAllowedTypes(['locales' => 'array']);
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

    private function prepareOptions($options, $replace)
    {
        $data = [];
        foreach ($options as $key => $value) {
            $data[$key] = empty($replace[$key]) ? $value : $replace[$key];
        }

        return $data;
    }
}
