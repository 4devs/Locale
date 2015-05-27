<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Intl\Intl;

class LocaleType extends AbstractType
{
    /**
     * @var string
     */
    private $fieldType = 'textarea';

    /**
     * init
     *
     * @param string $type
     */
    public function __construct($type = 'textarea')
    {
        $this->fieldType = $type;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $intlBundle = Intl::getLanguageBundle();

        if (is_array($options['lang_code'])) {
            $localeChoices = [];
            foreach ($options['lang_code'] as $code) {
                $localeChoices[$code] = $intlBundle->getLanguageName($code);
            }
            $builder->add('locale', 'choice', ['choices' => $localeChoices]);
        } else {
            $options['options']['label'] = $options['options']['label'] ?: $intlBundle->getLanguageName($options['lang_code']);
            $builder->add('locale', 'hidden', ['data' => $options['lang_code'], 'empty_data' => $options['lang_code']]);
        }
        $builder->add('text', $options['type'], $options['options']);
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(['lang_code'])
            ->setDefaults([
                'type'       => $this->fieldType,
                'compound'   => true,
                'data_class' => 'FDevs\Locale\Model\LocaleText',
                'options'    => [
                    'label'        => false,
                    'data_class'   => null,
                    'compound'     => false,
                    'required'     => true,
                    'read_only'    => false,
                    'max_length'   => null,
                    'mapped'       => true,
                    'by_reference' => true,
                    'trim'         => true,
                ]
            ])
            ->addAllowedTypes([
                'lang_code' => ['string', 'array'],
                'options'   => ['array'],
                'type'      => ['string', '\Symfony\Component\Form\FormTypeInterface']
            ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_locale';
    }
}
