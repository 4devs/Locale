<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Intl\Intl;

class LocaleTextType extends AbstractType
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
        $options['data_class'] = null;
        $options['compound'] = false;
        $options['property_path'] = null;
        $options['label'] = false;
        $localeData = [];
        $intlBundle = Intl::getLanguageBundle();

        if (is_array($options['lang_code'])) {
            $localeChoices = [];
            foreach ($options['lang_code'] as $code) {
                $localeChoices[$code] = $intlBundle->getLanguageName($code);
            }
            $builder->add('locale', 'choice', ['choices' => $localeChoices]);
        } else {
            $options['label'] = $intlBundle->getLanguageName($options['lang_code']);
            $localeData['data'] = $options['lang_code'];
            $builder->add('locale', 'hidden', $localeData);
        }
        unset($options['lang_code']);

        $builder->add('text', $this->fieldType, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(['lang_code'])
            ->setRequired(['lang_code'])
            ->setDefaults(['compound' => true, 'data_class' => 'FDevs\Locale\Model\LocaleText'])
            ->addAllowedTypes(['lang_code' => ['string', 'array']]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_locale_'.$this->fieldType;
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return $this->fieldType;
    }
}
