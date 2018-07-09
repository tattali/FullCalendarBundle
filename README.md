## FullCalendarBundle

[![Build Status](https://travis-ci.org/toiba/FullCalendarBundle.svg)](https://travis-ci.org/toiba/FullCalendarBundle)

This bundle allow you to integrate [FullCalendar.js](http://fullcalendar.io/) library in your Symfony3.

## Requirements
* FullCalendar.js v3.9.0
* Symfony v3.1+
* PHP v5.5+
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

         //You may want do a custom query to populate the events

         $calendarEvent->addEvent(new Event('Event Title 1', new \DateTime(), new \DateTime('+1 hour')));
         $calendarEvent->addEvent(new Event('Event Title 2', new \DateTime('+1 day'), new \DateTime('+1 day +1 hour')));
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
    <script type="text/javascript" src="{{ asset('bundles/fullcalendar/js/fullcalendar/fullcalendar.default-settings.js') }}"></script>
{% endblock %}
```

Install assets

```sh
$ php bin/console assets:install web
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
                url: '/full-calendar/load',
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

```javascript
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
                url: /fc-load-events,
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
