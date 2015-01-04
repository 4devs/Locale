<?php

namespace FDevs\Locale\Twig;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\Util\ChoiceText;

class TranslatorExtension extends \Twig_Extension
{
    /** @var \FDevs\Locale\Util\ChoiceText */
    private $choiceText;

    /**
     * init
     *
     * @param ChoiceText $choiceText
     */
    public function __construct(ChoiceText $choiceText)
    {
        $this->choiceText = $choiceText;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                't',
                [$this, 'trans'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    /**
     * translate Collection
     *
     * @param |FDevs\Locale\Model\LocaleText[]|string $data
     * @param string                                  $locale
     *
     * @return string
     */
    public function trans(\Twig_Environment $env, $data, $locale = '')
    {
        if ($data instanceof Collection) {
            $locale = $this->choiceText->getLocale($locale);
            $result = $this->choiceText->getTextByCollection($data, $locale);
            $twig = new \Twig_Environment(new \Twig_Loader_String());
            $twig->addExtension($env->getExtension('routing'));

            return $twig->render($result);
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'translator_extension';
    }
}
