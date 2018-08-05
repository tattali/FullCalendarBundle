# Documentation

**Symfony flex users skip step 2 and step 3** because they are done in the recipe

## Installation

1. [Download FullCalendarBundle using composer](#1-download-fullcalendarbundle-using-composer)
2. [Enable bundle](#2-enable-bundle)
3. [Add Routing](#3-define-routes)
4. [Create your listener](#4-create-your-listener)
5. [Add styles and scripts in your template](#5-add-styles-and-scripts-in-your-template)

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

### 3. Define routes

```yaml
# app/config/routing.yml

toiba_fullcalendar:
    resource: "@FullCalendarBundle/Resources/config/routing.yaml"
```

### 4. Create your listener
You need to create your listener class in order to load your events data in the calendar.

```yaml
# app/config/services.yml or config/services.yaml
services:
    # ...

    AppBundle\EventListener\FullCalendarListener:
        tags:
            - { name: 'kernel.event_listener', event: 'fullcalendar.set_data', method: loadEvents }
```

This listener is called when the event 'fullcalendar.set_data' is launched, for this reason you will need add this in your services.yml.

See the [doctrine listener example](doctrine-listener.md)

```php
// src/AppBundle/EventListener/FullCalendarListener.php
<?php

namespace AppBundle\EventListener;

use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    /**
     * @param CalendarEvent $calendar
     */
    public function loadEvents(CalendarEvent $calendar)
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // You may want do a custom query to populate the calendar
        
        $calendar->addEvent(new Event(
            'Event 1',
            new \DateTime('Tuesday this week'),
            new \DateTime('Wednesdays this week')
        ));

        // If end date is null or not defined, it create an all day event
        $calendar->addEvent(new Event(
            'Event All day',
            new \DateTime('Friday this week')
        ));
    }
}
```

### 5. Add styles and scripts in your template

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

Click [here](https://fullcalendar.io/download) to see other css and js download methods

## Basic functionalities

```js
$(function () {
    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        lazyFetching: true,
        eventSources: [
            {
                url: "{{ path('fullcalendar_load_events') }}",
                type: 'POST',
                data: {},
                error: function () {
                    alert('There was an error while fetching FullCalendar!');
                }
            }
        ]
    });
});
```

## Extending Basic functionalities

```js
$(function () {
    $('#calendar-holder').fullCalendar({
        locale: 'fr',
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, agendaWeek, agendaDay'
        },
        businessHours: {
            start: '09:00',
            end: '18:00',
            dow: [1, 2, 3, 4, 5]
        },
        allDaySlot: false,
        defaultView: 'agendaWeek',
        lazyFetching: true,
        navLinks: true,
        selectable: true,
        editable: true,
        eventDurationEditable: true,
        eventSources: [
            {
                url: "{{ path('fullcalendar_load_events') }}",
                type: 'POST',
                data: {
                    filters: {
                        'foo': 'bar'
                    }
                },
                error: function () {
                    alert('There was an error while fetching FullCalendar!');
                }
            }
        ]
    });
});
```
