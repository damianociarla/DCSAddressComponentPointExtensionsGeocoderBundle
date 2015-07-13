<?php

namespace DCS\AddressComponent\PointExtensions\GeocoderBundle;

use DCS\AddressComponent\PointExtensions\GeocoderBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DCSAddressComponentPointExtensionsGeocoderBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TwigFormPass());
    }
}
