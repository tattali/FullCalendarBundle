# Doctrine listener

We need to inject doctrine `EntityManager` to the event listener

```php
// src/AppBundle/EventListener/FullCalendarListener.php

<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
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

        // Modify the query to fit to your entity and needs
        // b.beginAt is the start date in the booking entity
        $bookings = $this->em->getRepository(Booking::class)
            ->createQueryBuilder('b')
            ->andWhere('b.beginAt BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();

        foreach($bookings as $booking) {

            // create the events with your own entity (here booking entity)
            $bookingEvent = new Event(
                $booking->getTitle(),
                $booking->getBeginAt(),
                $booking->getEndAt() // If end date is null or not defined, it create an all day event
            );

            /*
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $bookingEvent->setBackgroundColor($booking->getColor());
            // $bookingEvent->setCustomField('borderColor', $booking->getColor());

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($bookingEvent);
        }
    }
}
```

Finish installation by adding [style and js](index.md#5-add-styles-and-scripts-in-your-template)

## Next steps
[Link the calendar to a CRUD](doctrine-crud.md)
