<?php

namespace DCS\AddressComponent\PointExtensions\GeocoderBundle\EventListener;

use DCS\AddressBundle\DCSAddressEvents;
use DCS\AddressBundle\Event\FormattedAddressEvent;
use DCS\AddressComponent\PointBundle\Model\AddressPointInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DCSAddressEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            DCSAddressEvents::TWIG_FORMATTED_ADDRESS => array('formatAddress', 10),
        );
    }

    public function formatAddress(FormattedAddressEvent $event)
    {
        $addressComponent = $event->getAddress()->getComponent();

        if (!$addressComponent instanceof AddressPointInterface) {
            return;
        }

        $geoInfo = $addressComponent->getGeoInfo();

        if (empty($geoInfo)) {
            return;
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

        $event->setFormattedAddress(implode(', ', $addressInfo));
        $event->stopPropagation();
    }
}