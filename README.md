## FullCalendarBundle

[![Build Status](https://travis-ci.org/toiba/FullCalendarBundle.svg)](https://travis-ci.org/toiba/FullCalendarBundle)

This bundle allow you to integrate [FullCalendar.js](http://fullcalendar.io/) library in your Symfony3.

## Requirements
* FullCalendar.js v3.9.0
* Symfony 3.0/4.0
* PHP v5.6+
* PHPSpec

Installation
------------

1. [Download FullCalendarBundle using composer](#download-fullcalendarbundle)
2. [Enable bundle](#enable-bundle)
3. [Add Routing](#routing)
4. [Create your listener](#create-listener)
5. [Add styles and scripts in your template](#styles-scripts)

### 1. Download FullCalendarBundle using composer

```sh
$ composer require toiba/fullcalendar-bundle
```

### 2. Enable bundle

```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        //...
        new Toiba\FullCalendarBundle\FullCalendarBundle(),
    );
}
```

### 3. Define routes by default

```yml
# app/config/routing.yml

toiba_fullcalendar:
    resource: "@FullCalendarBundle/Resources/config/routing.yml"
```

### 4. Create your listener
You need to create your listener/subscriber class in order to load your events data in the calendar.

```yml
# app/config/services.yml
services:
    AppBundle\EventListener\FullCalendarListener:
        tags:
            - { name: 'kernel.event_listener', event: 'fullcalendar.set_data', method: loadData }
```

This listener is called when the event 'fullcalendar.set_data' is launched, for this reason you will need add this in your services.yml.

```php
// src/AppBundle/EventListener/FullCalendarListener.php

<?php

namespace AppBundle\EventListener;

use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStart();
        $endDate = $calendarEvent->getEnd();
        $filters = $calendarEvent->getFilters();

        //You may want do a custom query to populate the calendar

        $bookings = [
            'booking_1' => array(
                'beginAt' => new \DateTime('Monday this week 12:00:00'),
                'endAt' => new \DateTime('Monday this week 13:00:00'),
                'bgColor' => 'green',
                'border' => true,
            ),
            'booking_2' => array(
                'beginAt' => new \DateTime('Wednesday this week 12:00:00'),
                'endAt' => new \DateTime('Wednesday this week 13:00:00'),
                'bgColor' => 'orange',
                'border' => true,
            ),
            'booking_3' => array(
                'beginAt' => new \DateTime('Friday this week 12:00:00'),
                'endAt' => new \DateTime('Friday this week 13:00:00'),
                'bgColor' => 'blue',
                'border' => false,
            ),
        ];

        foreach($bookings as $title => $booking) {

            // create an event with a start/end time
            $event = new Event(
                $title,
                $booking['beginAt'],
                $booking['endAt']
            );

            /*
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            $event->setBackgroundColor($booking['bgColor']);
            $event->setCustomField('borderColor', $booking['bgColor']);

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($event);
        }
    }
}
```

### 5. Add styles and scripts in your template

Add html template to display the calendar:

```twig
{% block body %}
    {% include '@FullCalendar/Calendar/calendar.html.twig' %}
{% endblock %}
```

Add styles:

```twig
{% block stylesheets %}
    <link rel="stylesheet" href="{{ asset('bundles/fullcalendar/css/fullcalendar/fullcalendar.min.css') }}" />
{% endblock %}
```

Add javascript:

```twig
{% block javascripts %}
    <script type="text/javascript" src="{{ asset('bundles/fullcalendar/js/fullcalendar/lib/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/fullcalendar/js/fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/fullcalendar/js/fullcalendar/fullcalendar.min.js') }}"></script>
{% endblock %}
```

# Basic functionalities

```js
$(function () {
    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'month, basicWeek, basicDay,'
        },
        lazyFetching: true,
        timeFormat: {
            agenda: 'h:mmt',
            '': 'h:mmt'
        },
        eventSources: [
            {
                url: "{{ path('fullcalendar_load_events') }}",
                type: 'POST',
                data: {},
                error: function () {}
            }
        ]
    });
});
```

# Extending Basic functionalities

## Extending the Calendar Javascript
If you want to customize the FullCalendar javascript you can copy the fullcalendar.default-settings.js in YourBundle/Resources/public/js, and add your own logic:

```js
$(function () {
    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, agendaWeek, agendaDay'
        },
        timezone: ('Europe/Paris'),
        businessHours: {
            start: '09:00',
            end: '18:00',
            dow: [1, 2, 3, 4, 5]
        },
        allDaySlot: false,
        defaultView: 'agendaWeek',
        lazyFetching: true,
        firstDay: 1,
        selectable: true,
        timeFormat: {
            agenda: 'h:mmt',
            '': 'h:mmt'
        },
        columnFormat:{
            month: 'ddd',
            week: 'ddd D/M',
            day: 'dddd'
        },
        editable: true,
        eventDurationEditable: true,
        eventSources: [
            {
                url: "{{ path('fullcalendar_load_events') }}",
                type: 'POST',
                data: {
                    filters: { foo: bar }
                }
                error: function() {
                   // alert('There was an error while fetching FullCalendar!')
                }
            }
        ]
    });
});
```

Contribute and feedback
-------------------------

Any feedback and contribution will be very appreciated.
