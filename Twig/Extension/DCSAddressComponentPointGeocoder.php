<?php

namespace DCS\AddressComponent\PointExtensions\GeocoderBundle\Twig\Extension;

use DCS\AddressBundle\Model\AddressInterface;
use DCS\AddressComponent\PointBundle\Model\AddressPointInterface;

class DCSAddressComponentPointGeocoder extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('full_address', array($this, 'getFullAddressFilter')),
            new \Twig_SimpleFilter('short_address', array($this, 'getShortAddressFilter')),
            new \Twig_SimpleFilter('basic_address', array($this, 'getBasicAddressFilter')),
        );
    }

    public function getFullAddressFilter($address)
    {
        if (null === $geoInfo = $this->getGeoInfo($address)) {
            return '';
        }

        $addressInfo = array();

        if (!empty($geoInfo['streetName'])) {
            $addressInfo[] = $geoInfo['streetName'];
            if (!empty($geoInfo['streetNumber'])) {
                $addressInfo[] = $geoInfo['streetNumber'];
            }
        }
        if (!empty($geoInfo['zipcode'])) {
            $addressInfo[] = $geoInfo['zipcode'];
        }
        if (!empty($geoInfo['city'])) {
            $addressInfo[] = $geoInfo['city'];
        }
        if (!empty($geoInfo['country'])) {
            $addressInfo[] = $geoInfo['country'];
        }

        return implode(', ', $addressInfo);
    }

    public function getShortAddressFilter($address)
    {
        if (null === $geoInfo = $this->getGeoInfo($address)) {
            return '';
        }

        $addressInfo = array();

        if (!empty($geoInfo['streetName'])) {
            $addressInfo[] = $geoInfo['streetName'];
            if (!empty($geoInfo['streetNumber'])) {
                $addressInfo[] = $geoInfo['streetNumber'];
            }
        }
        if (!empty($geoInfo['city'])) {
            $addressInfo[] = $geoInfo['city'];
        }

        return implode(', ', $addressInfo);
    }

    public function getBasicAddressFilter($address)
    {
        if (null === $geoInfo = $this->getGeoInfo($address)) {
            return '';
        }

        $addressInfo = array();

        if (!empty($geoInfo['city'])) {
            $addressInfo[] = $geoInfo['city'];
        }
        if (!empty($geoInfo['country'])) {
            $addressInfo[] = $geoInfo['country'];
        }

        return implode(', ', $addressInfo);
    }

    private function getGeoInfo($address)
    {
        if ($address instanceof AddressInterface) {
            $addressComponent = $address->getComponent();
        }

        if (!$addressComponent instanceof AddressPointInterface) {
            return null;
        }

        $geoInfo = $addressComponent->getGeoInfo();

        if (empty($geoInfo)) {
            return null;
        }

        return $geoInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dcs_address_component_point_geocoder';
    }
}
