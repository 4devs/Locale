<?php

namespace FDevs\Locale\Twig;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\Model\LocaleText;
use FDevs\Locale\Translator;
use FDevs\Locale\TranslatorInterface;

class TranslatorExtension extends \Twig_Extension
{
    /** @var array */
    private $twigExtensions = [];

    /** @var TranslatorInterface */
    private $translator;

    /** @var \Twig_Environment */
    private $environment;

    /**
     * init
     *
     * @param array               $twigExtensions
     * @param TranslatorInterface $translator
     */
    public function __construct(array $twigExtensions = [], TranslatorInterface $translator)
    {
        $this->twigExtensions = $twigExtensions;
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('t', [$this, 'trans'], ['is_safe' => ['html'], 'needs_environment' => true]),
            new \Twig_SimpleFilter('tc', [$this, 'translationCollection'], ['is_safe' => ['html']]),
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
        if ($data instanceof Collection || is_array($data)) {
            $text = $this->translator->trans($data, $locale);
            $data = '';
            if ($text instanceof LocaleText && $text->getText()) {
                $data = $this->createTemplate($text->getText(), $env)->render([]);
            }
        }

        return $data;
    }

    /**
     * @param \FDevs\Locale\LocaleInterface|string $data
     * @param string                               $locale
     *
     * @return \FDevs\Locale\LocaleInterface|null
     */
    public function translationCollection($data, $locale = '')
    {
        if ($data instanceof Collection || is_array($data)) {
            $data = $this->translator->trans($data, $locale);
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

    /**
     * create template
     *
     * @param string            $text
     * @param \Twig_Environment $env
     *
     * @return \Twig_Template
     */
    private function createTemplate($text, \Twig_Environment $env)
    {
        if (!$this->environment) {
            $this->environment = new \Twig_Environment($env->getLoader());
            foreach ($this->twigExtensions as $ext) {
                if (!$ext instanceof \Twig_ExtensionInterface) {
                    $ext = $env->getExtension($ext);
                }
                $this->environment->addExtension($ext);
            }
        }

        return $this->environment->createTemplate($text);
    }
}
