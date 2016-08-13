<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            $builder->add('locale', ChoiceType::class, ['choices' => $localeChoices]);
        } else {
            $builder->add('locale', HiddenType::class, ['data' => $options['lang_code'], 'empty_data' => $options['lang_code']]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['lang_code'])
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
                ],
            ])
            ->addAllowedTypes('lang_code', ['string', 'array'])
            ->addAllowedTypes('options', ['array'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return 'fdevs_locale';
    }
}
