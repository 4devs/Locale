<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Intl\Intl;

class LocaleType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (is_array($options['lang_code'])) {
            $intlBundle = Intl::getLanguageBundle();
            $localeChoices = [];
            foreach ($options['lang_code'] as $code) {
                $localeChoices[$code] = $intlBundle->getLanguageName($code);
            }
            $builder->add('locale', 'choice', ['choices' => $localeChoices]);
        } else {
            $builder->add('locale', 'hidden', ['data' => $options['lang_code'], 'empty_data' => $options['lang_code']]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(['lang_code', 'type'])
            ->setDefaults([
                'compound' => true,
                'options'  => [
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
            ])
            ->setNormalizers(['options' => function ($options, $value) {
                if (is_string($options['lang_code']) && !$value['label']) {
                    $value['label'] = Intl::getLanguageBundle()->getLanguageName($options['lang_code']);
                }

                return $value;
            }]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_locale';
    }
}
