<?php

namespace spec\Toiba\FullCalendarBundle\Controller;

use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Toiba\FullCalendarBundle\Controller\CalendarController;
use Toiba\FullCalendarBundle\Service\Calendar;

/**
 * @mixin \Toiba\FullCalendarBundle\Controller\CalendarController
 */
class CalendarControllerSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    public function itIsInitializable()
    {
        $this->shouldHaveType(CalendarController::class);
    }

    public function itIsASymfonyController()
    {
        $this->shouldHaveType(Controller::class);
    }

    public function itProvidesAnEventsFeedForACalendar(
        Request $request,
        Calendar $calendar,
        ContainerInterface $container
    ) {
        $request->get('start')->willReturn('2016-03-01');
        $request->get('end')->willReturn('2016-03-19 15:11:00');
        $request->get('filters', [])->willReturn([]);

        $container->get('fullcalendar.service.calendar')->willReturn($calendar);

        $data = <<<'JSON'
[
  {
    "title": "Birthday!",
    "allDay": true,
    "start": "2016-03-01",

  }, {
    "title": "Flight to somewhere sunny",
    "allDay": false,
    "start": "2016-03-12T08:55:00Z",
    "end": "2016-03-12T11:50:00Z"
  }
]
JSON;

        $calendar
            ->getData(
                new \DateTime('2016-03-01'),
                new \DateTime('2016-03-19 15:11:00'),
                []
            )
            ->willReturn($data)
        ;

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($data);
        $response->setStatusCode(200);

        // $response->setSharedMaxAge(600);

        $this->loadAction($request)->shouldBeLike($response);
    }
}
