<?php

namespace DCS\AddressComponent\PointExtensions\GeocoderBundle\EventListener;

use Bazinga\Bundle\GeocoderBundle\Geocoder\LoggableGeocoder;
use DCS\AddressComponent\PointBundle\DCSAddressComponentPointEvents;
use DCS\AddressComponent\PointBundle\Event\AddressPointEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DCSAddressComponentPointEventSubscriber implements EventSubscriberInterface
{
    private $geocoder;

    public function __construct(LoggableGeocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    public static function getSubscribedEvents()
    {
        return array(
            DCSAddressComponentPointEvents::BEFORE_SAVE_ADDRESS => 'geocodePoint',
        );
    }

    public function geocodePoint(AddressPointEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $addressPoint = $event->getAddressPoint();

        try {
            $geoInfo = $this->geocoder->reverse(
                $addressPoint->getPoint()->getLatitude(),
                $addressPoint->getPoint()->getLongitude()
            )->toArray();
        } catch (\Exception $e) {
            $geoInfo = null;
        }

        $addressPoint->setGeoInfo($geoInfo);
    }
}