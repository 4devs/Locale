<?php

namespace FDevs\Locale\Twig;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\Translator;
use FDevs\Locale\TranslatorInterface;
use FDevs\Locale\Util\ChoiceText;

class TranslatorExtension extends \Twig_Extension
{
    /** @var array */
    private $twigExtensions = [];

    /** @var TranslatorInterface */
    private $translator;

    /**
     * init
     *
     * @param array                    $twigExtensions
     * @param string                   $defaultLocale
     * @param TranslatorInterface|null $translator
     */
    public function __construct(array $twigExtensions = [], $defaultLocale = '', TranslatorInterface $translator = null)
    {
        $this->twigExtensions = $twigExtensions;
        $this->translator = is_null($translator) ? new Translator($defaultLocale) : $translator;
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
     * @param string $locale
     *
     * @return string
     */
    public function trans(\Twig_Environment $env, $data, $locale = '')
    {
        if ($data instanceof Collection) {
            $twig = new \Twig_Environment(new \Twig_Loader_String());
            foreach ($this->twigExtensions as $ext) {
                if (!$ext instanceof \Twig_ExtensionInterface) {
                    $ext = $env->getExtension($ext);
                }
                $twig->addExtension($ext);
            }

            $data = $twig->render($this->translator->trans($data, $locale));
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
     * get Default Locale
     *
     * @return string
     * @deprecated
     */
    public function getDefaultLocale()
    {
        return $this->translator->getLocale();
    }

    /**
     * set Default Locale
     *
     * @param string $defaultLocale
     *
     * @return $this
     * @deprecated
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->translator->setLocale($defaultLocale);

        return $this;
    }
}
