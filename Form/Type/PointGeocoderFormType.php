<?php

namespace DCS\AddressComponent\PointExtensions\GeocoderBundle\Form\Type;

use DCS\AddressComponent\PointExtensions\GeocoderBundle\DependencyInjection\Configuration;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointGeocoderFormType extends AbstractTypeExtension
{
    private $googleMapsApiKey;
    private $defaultConfig;

    public function __construct($googleMapsApiKey, array $defaultConfig)
    {
        $this->googleMapsApiKey = $googleMapsApiKey;
        $this->defaultConfig = $defaultConfig;
    }

    public function getExtendedType()
    {
        return 'dcs_address_component_address_point';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults($this->defaultConfig);

        $resolver->setDefined(array(
            'view_method',
            'locale_api',
            'load_js_api',
            'map_id',
            'center',
        ));
    }

    /**
     * @inheritDoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array(
            'api_key'     => $this->googleMapsApiKey,
            'view_method' => $options['view_method'],
            'locale_api'  => $options['locale_api'],
            'load_js_api' => $options['load_js_api'],
            'map_id'      => $options['map_id'],
            'center'      => $options['center'],
        ));
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if (in_array($options['view_method'], array(
            Configuration::METHOD_AUTOCOMPLETE,
            Configuration::METHOD_CHAIN)
        )) {
            $builder->add('_address', 'text', array(
                'required' => false,
                'label' => 'form.label.address',
                'mapped' => false,
            ));
        }
    }
}