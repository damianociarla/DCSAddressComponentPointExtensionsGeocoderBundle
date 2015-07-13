<?php

namespace DCS\AddressComponent\PointExtensions\GeocoderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const METHOD_AUTOCOMPLETE   = 'autocomplete';
    const METHOD_MANUAL         = 'manual';
    const METHOD_CHAIN          = 'chain';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dcs_address_component_point_extensions_geocoder');

        $rootNode
            ->children()
                ->scalarNode('google_maps_api_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('default')
                    ->isRequired()
                    ->children()
                        ->enumNode('view_method')
                            ->values(array(
                                static::METHOD_AUTOCOMPLETE,
                                static::METHOD_MANUAL,
                                static::METHOD_CHAIN,
                            ))
                            ->isRequired()
                        ->end()
                        ->scalarNode('locale_api')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('map_id')
                            ->defaultValue('dcs-address-component-point-extension-geocoder-map')
                            ->cannotBeEmpty()
                        ->end()
                        ->booleanNode('load_js_api')
                            ->isRequired()
                        ->end()
                        ->arrayNode('center')
                            ->isRequired()
                            ->children()
                                ->scalarNode('lat')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('lng')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
