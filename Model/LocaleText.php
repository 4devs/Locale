<?php

namespace FDevs\Locale\Model;

use FDevs\Locale\LocaleTextInterface;
use FDevs\Locale\LocaleTrait;

class LocaleText implements LocaleTextInterface, \Serializable
{
    use LocaleTrait;
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $text;

    /**
     * init
     *
     * @param string $text
     * @param string $locale
     */
    public function __construct($text = '', $locale = 'en')
    {
        $this->text = $text;
        $this->setLocale($locale);
    }

    /**
     * to Array
     *
     * @return array
     */
    public function toArray()
    {
        return ['locale' => $this->getLocale(), 'text' => $this->text];
    }

    /**
     * from Array
     *
     * @param array $array
     *
     * @return $this
     */
    public function fromArray(array $array)
    {
        if (!empty($array['locale'])) {
            $this->setLocale($array['locale']);
        }
        $this->text = empty($array['text']) ? '' : $array['text'];

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->text ?: '';
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize([
            'locale' => $this->getLocale(),
            'text'   => $this->getText(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->setLocale($data['locale']);
        $this->setText($data['text']);

        return $this;
    }
}
