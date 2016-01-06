<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChoiceLocaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $intlBundle = Intl::getLanguageBundle();
        $builder->add('locale', ChoiceType::class, [
            'choices' => $options['lang_code'],
            'choices_as_values' => true,
            'choice_label' => function ($lang) use ($intlBundle) {
                return $intlBundle->getLanguageName($lang);
            },
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['lang_code'])
            ->setDefaults([
                'compound' => true,
                'options' => [
                    'label' => false,
                    'data_class' => null,
                    'compound' => false,
                    'required' => true,
                    'mapped' => true,
                    'by_reference' => true,
                    'trim' => true,
                ],
            ])
            ->addAllowedTypes('options', ['array'])
            ->addAllowedTypes('lang_code', ['array'])
        ;
    }
}
