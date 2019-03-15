# Basic CRUD example with Doctrine and FullCalendarBundle

This example allow you to create, update, delete & show events with `FullCalendarBundle`

## Installation

1. [Download FullCalendarBundle using composer](#1-download-fullcalendarbundle-using-composer)
2. [Create the crud](#2-create-the-crud)
3. [Use an event listener to connect all of this together](#3-use-an-event-listener-to-connect-all-of-this-together)

### 1. Download FullCalendarBundle using composer

This documentation assumes that doctrine is already installed. 

> **NOTE:** `composer req doctrine` then update the database url in your `.env` and run `bin/console d:d:c`

```sh
$ composer require toiba/fullcalendar-bundle
```
The recipe will import the routes for you

### 2. Create the CRUD

Generate or create an entity with at least a *start date* and a *title*. You also can add an *end date*

```sh
# Symfony flex (Need the maker: `composer req maker`)
$ php bin/console make:entity
```

For this example we call the entity `Booking`
```php
// src/Entity/Booking.php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt = null): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
```

```php
// src/Repository/BookingRepository.php
<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }
}
```

Then, update your database schema
```
$ php bin/console doctrine:migration:diff
$ php bin/console doctrine:migration:migrate -n
```

And, create or generate a CRUD for your entity by running:
```sh
php bin/console make:crud Booking
```

Edit the `BookingController` by adding a `calendar()` action to display the calendar
```php
// src/Controller/BookingController.php
<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    // ...

    /**
     * @Route("/calendar", name="booking_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('booking/calendar.html.twig');
    }

    // ...
}
```

Then create the calendar template

and with a link to the `booking_new` form and the `calendar-holder`
```twig
{# templates/booking/calendar.html.twig #}
{% extends 'base.html.twig' %}

{% block body %}
    <a href="{{ path('booking_new') }}">Create new booking</a>

    {% include '@FullCalendar/Calendar/calendar.html.twig' %}
{% endblock %}

{% block stylesheets %}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css">
{% endblock %}

{% block javascripts %}
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://momentjs.com/downloads/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale/fr.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#calendar-holder").fullCalendar({
                eventSources: [
                    {
                        url: "{{ path('fullcalendar_load_events') }}",
                        type: "POST",
                        data: {
                            filters: {},
                        },
                        error: function () {
                            // alert("There was an error while fetching FullCalendar!");
                        }
                    }
                ],
                header: {
                    center: "title",
                    left: "prev,next today",
                    right: "month,agendaWeek,agendaDay"
                },
                lazyFetching: true,
                locale: "fr",
                navLinks: true, // can click day/week names to navigate views
            });
        });
    </script>
{% endblock %}
```

### 3. Use an event listener to connect all of this together

We now have to link the CRUD to the calendar by adding the `booking_show` link in each events

To do this create a listener with access to the router component and your entity repository
```php
// src/EventListener/FullCalendarListener.php
<?php

namespace App\EventListener;

// ...
use App\Repository\BookingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

    // ...
```

Then use `setUrl()` on each created event to link them to their own show action
```php
$bookingEvent->setUrl(
    $this->router->generate('booking_show', [
        'id' => $booking->getId(),
    ])
);
```

Full listener with `Booking` entity. Modify it to fit your needs.
```php
// src/EventListener/FullCalendarListener.php
<?php

namespace App\EventListener;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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

Register the listener as a service to listen `fullcalendar.set_data` event
```yaml
# config/services.yaml
services:
    # ...

    App\EventListener\FullCalendarListener:
        tags:
            - { name: 'kernel.event_listener', event: 'fullcalendar.set_data', method: loadEvents }
```
* Now visit: http://localhost:8000/booking/calendar

* In the calendar when you click on an event it call the `show()` action that should contains an edit and delete link

* And when you create a new `Booking` (or your custom entity name) it appear on the calendar

* If you have created a custom entity don't forget to modify the listener:
    - Replace all `Booking` or `booking` by your custom entity name
    - In the query near the `andWhere` modify `beginAt` to your custom start date property
    - Also when you create each `Event` in the `foreach` modify the getters to fit with your entity

* You may want to customize the fullcalendar.js settings to meet your application needs. To do this, see the [official fullcalendar documentation](https://fullcalendar.io/docs#toc) or also look the [extending basic functionalities](https://github.com/toiba/FullCalendarBundle/blob/master/doc/index.md#extending-basic-functionalities) in the bundle documentation.

<br>

* To debug AJAX requests, show the Network monitor, then reload the page. Finally click on `fc-load-events` and select the `Response` or `Preview` tab
    - Firefox: `Ctrl + Shift + E` ( `Command + Option + E` on Mac )
    - Chrome: `Ctrl + Shift + I` ( `Command + Option + I` on Mac )
