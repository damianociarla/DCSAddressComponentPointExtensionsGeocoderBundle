<?php

namespace DCS\AddressComponent\PointExtensions\GeocoderBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DCSAddressComponentPointExtensionsGeocoderExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('dcs_address_component_point_extensions_geocoder.google_maps_api_key', $config['google_maps_api_key']);
        $container->setParameter('dcs_address_component_point_extensions_geocoder.default_config', $config['default']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form.xml');
        $loader->load('listener.xml');
        $loader->load('twig.xml');
    }
}
