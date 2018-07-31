# Doctrine listener
We need to inject doctrine entity manager to the event listener

```yaml
# app/config/services.yml or config/services.yaml
services:
    AppBundle\EventListener\FullCalendarListener:
        arguments: [ "@doctrine.orm.entity_manager" ]
        tags:
            - { name: kernel.event_listener', event: 'fullcalendar.set_data', method: loadEvents }
```

This listener is called when the event 'fullcalendar.set_data' is launched.

```php
// src/AppBundle/EventListener/FullCalendarListener.php

<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Booking;
use Doctrine\ORM\EntityManager;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param CalendarEvent $calendar
     */
    public function loadEvents(CalendarEvent $calendar)
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // You may want do a custom query to populate the calendar
        // b.beginAt is the start date in the booking entity
        $bookings = $this->em->getRepository(Booking::class)
            ->createQueryBuilder('b')
            ->andWhere('b.beginAt BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();

        foreach($bookings as $booking) {

            // create an event with the booking data
            $bookingEvent = new Event(
                $booking->getTitle(),
                $booking->getBeginAt(),
                $booking->getEndAt() // If end date is null or not defined, it create an all day event
            );

            /*
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $bookingEvent->setBackgroundColor($booking['bgColor']);
            // $bookingEvent->setCustomField('borderColor', $booking['bgColor']);

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($bookingEvent);
        }
    }
}
```
