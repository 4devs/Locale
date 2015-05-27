<?php

namespace FDevs\Locale\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class TranslatableFormSubscriber implements EventSubscriberInterface
{
    /** @var array */
    private $locales = [];

    /** @var array */
    private $options = [];

    /** @var string */
    private $localeFormType;

    /**
     * init
     *
     * @param array  $options
     * @param array  $locations
     * @param string $localeFormType
     */
    public function __construct($localeFormType = 'fdevs_locale', array $options = [], array $locations = [])
    {
        $this->options = $options;
        $this->localeFormType = $localeFormType;
        $this->setLocales($locations);
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    /**
     * {@inheritDoc}
     */
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (null === $data) {
            $data = [];
        }

        if (!is_array($data) && !($data instanceof \Traversable && $data instanceof \ArrayAccess)) {
            throw new UnexpectedTypeException($data, 'array or (\Traversable and \ArrayAccess)');
        }

        // First remove all rows
        foreach ($form as $name => $child) {
            $form->remove($name);
        }
        foreach ($data as $name => $value) {
            $locale = $value->getLocale();
            if (isset($this->locales[$locale])) {
                $this->addForm($form, $name, $locale);
                unset($this->locales[$locale]);
            }
        }

        $name = count($data);
        foreach ($this->locales as $locale => $value) {
            $this->addForm($form, $name, $locale);
            $name++;
        }
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
        $this->locales = array_flip($locales);

        return $this;
    }

    /**
     * add Element Form
     *
     * @param FormInterface $form
     * @param string        $name
     * @param string        $locale
     */
    private function addForm(FormInterface $form, $name, $locale)
    {
        $options = array_replace([
            'label'         => false,
            'property_path' => '['.$name.']',
            'lang_code'     => $locale
        ], $this->options);

        $form->add($name, $this->localeFormType, $options);
    }
}
