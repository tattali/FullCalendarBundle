FullCalendarBundle - jQuery Calendar bundle
===========================================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/toiba/FullCalendarBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/toiba/FullCalendarBundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/toiba/FullCalendarBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/toiba/FullCalendarBundle/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/toiba/FullCalendarBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/toiba/FullCalendarBundle/build-status/master)
[![Total Downloads](https://poser.pugx.org/toiba/fullcalendar-bundle/downloads)](https://packagist.org/packages/toiba/fullcalendar-bundle)
[![Packagist](https://poser.pugx.org/toiba/fullcalendar-bundle/version)](https://packagist.org/packages/toiba/fullcalendar-bundle)

[DEPRECATED] Use [tattali/CalendarBundle](https://github.com/tattali/CalendarBundle)

This bundle allow you to integrate [FullCalendar.js](http://fullcalendar.io/) library in your Symfony 4 project.

<p align="center">
  <img src="https://user-images.githubusercontent.com/10502887/43464490-8499d962-94db-11e8-8455-f688c2e7ad1d.png" alt="FullCalendar image">
</div>

* Symfony 3.4+ or Symfony 4.0+
* No storage dependencies (Compatible with: Doctrine, MongoDB, CouchDB...)
* PHP v5.6+
* PHPSpec

Documentation
-------------

The source of the documentation is stored in the `doc/` folder in this bundle :

[Link the calendar to a CRUD and allow create, update, delete & show events](doc/doctrine-crud.md)

[Symfony 3.4 installation](doc/sf3-4.md)

All the installation instructions are located in the documentation.

### Installation

1. [Download FullCalendarBundle using composer](#1-download-fullcalendarbundle-using-composer)
2. [Create the listener](#2-create-the-listener)
3. [Add styles and scripts in your template](#3-add-styles-and-scripts-in-your-template)

#### 1. Download FullCalendarBundle using composer

```sh
$ composer require toiba/fullcalendar-bundle
```
The recipe will import the routes for you

#### 2. Create the listener
You need to create a listener class to load your data into the calendar and register it as a service.

This listener must be called when the event `fullcalendar.set_data` is launched.
```yaml
# config/services.yaml
services:
    # ...

    App\EventListener\FullCalendarListener:
        tags:
            - { name: 'kernel.event_listener', event: 'fullcalendar.set_data', method: loadEvents }
```

Then, create the listener class to populate the calendar

See the [doctrine listener example](doc/doctrine-crud.md#4-use-an-event-listener-to-connect-all-of-this-together)

```php
// src/EventListener/FullCalendarListener.php
<?php

namespace App\EventListener;

use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    public function loadEvents(CalendarEvent $calendar)
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // You may want to make a custom query to populate the calendar

        $calendar->addEvent(new Event(
            'Event 1',
            new \DateTime('Tuesday this week'),
            new \DateTime('Wednesdays this week')
        ));

        // If the end date is null or not defined, it creates a all day event
        $calendar->addEvent(new Event(
            'Event All day',
            new \DateTime('Friday this week')
        ));
    }
}
```

#### 3. Add styles and scripts in your template

Include the html template were you want to display the calendar:

```twig
{% block body %}
    {% include '@FullCalendar/Calendar/calendar.html.twig' %}
{% endblock %}
```

Add styles and js. Click [here](https://fullcalendar.io/download) to see other css and js download methods

```twig
{% block stylesheets %}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css">
{% endblock %}

{% block javascripts %}
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://momentjs.com/downloads/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>

    {# <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale-all.js"></script> #}
{% endblock %}
```

### Basic functionalities

You will probably want to customize the FullCalendar javascript to fit the needs of your application.
To do this, you can copy the following settings and modify them by consulting the [fullcalendar.js documentation](https://fullcalendar.io/docs). You can also look at the [options.ts](https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts) file as an option reference.
```js
$(document).ready(function() {
    $("#calendar-holder").fullCalendar({
        eventSources: [
            {
                url: "/fc-load-events",
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
```

### Extending Basic functionalities

```js
$(document).ready(function() {
    $("#calendar-holder").fullCalendar({
        businessHours: {
            start: "09:00",
            end: "18:00",
            dow: [1, 2, 3, 4, 5]
        },
        defaultView: "agendaWeek",
        editable: true,
        eventDurationEditable: true,
        eventSources: [
            {
                url: "/fc-load-events",
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
        navLinks: true,
        selectable: true,
    });
});
```

## Troubleshoot AJAX requests

* To debug AJAX requests, show the Network monitor, then reload the page. Finally click on `fc-load-events` and select the `Response` or `Preview` tab
    - Firefox: `Ctrl + Shift + E` ( `Command + Option + E` on Mac )
    - Chrome: `Ctrl + Shift + I` ( `Command + Option + I` on Mac )

Contribute and feedback
-----------------------

Any feedback and contribution will be very appreciated.

License
-------

This bundle is under the MIT license. See the complete [license](LICENSE) in the bundle
