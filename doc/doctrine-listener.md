# Doctrine listener

After [registering the listener as a service](index.md#2-create-your-listener)

You need to inject the repository of your entity for example: `BookingRepository`

```php
// src/EventListener/FullCalendarListener.php
<?php

namespace App\EventListener;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    private $bookingRepository;
    private $router;

    public function __construct(
        BookingRepository $bookingRepository,
        UrlGeneratorInterface $router
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->router = $router;
    }

    public function loadEvents(CalendarEvent $calendar): void
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change b.beginAt by your start date in your custom entity
        $bookings = $this->bookingRepository
            ->createQueryBuilder('b')
            ->andWhere('b.beginAt BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($bookings as $booking) {

            // this create the events with your own entity (here booking entity) to populate calendar
            $bookingEvent = new Event(
                $booking->getTitle(),
                $booking->getBeginAt(),
                $booking->getEndAt() // If the end date is null or not defined, it creates a all day event
            );

            /*
             * Optional calendar event settings
             *
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $bookingEvent->setUrl('http://www.google.com');
            // $bookingEvent->setBackgroundColor($booking->getColor());
            // $bookingEvent->setCustomField('borderColor', $booking->getColor());

            $bookingEvent->setUrl(
                $this->router->generate('booking_show', [
                    'id' => $booking->getId(),
                ])
            );

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($bookingEvent);
        }
    }
}
```

Finish installation by adding [css and js](index.md#3-add-styles-and-scripts-in-your-template)

## Next steps
[Link the calendar to a CRUD to allow create, update, delete & show events](doctrine-crud.md)
