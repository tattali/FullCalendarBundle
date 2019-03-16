<?php

namespace spec\Toiba\FullCalendarBundle\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;
use Toiba\FullCalendarBundle\Service\Calendar;
use Toiba\FullCalendarBundle\Service\SerializerInterface;

class CalendarSpec extends ObjectBehavior
{
    public function let(
        SerializerInterface $serializer,
        EventDispatcherInterface $dispatcher
    ) {
        $this->beConstructedWith($serializer, $dispatcher);
    }

    public function itIsInitializable()
    {
        $this->shouldHaveType(Calendar::class);
    }

    public function itGetsAJsonString(
        SerializerInterface $serializer,
        EventDispatcherInterface $dispatcher,
        CalendarEvent $calendarEvent,
        Event $event
    ) {
        $startDate = new \DateTime();
        $endDate = new \DateTime();
        $events = [$event];
        $json = '{ [events: foo] }';

        $dispatcher
            ->dispatch(CalendarEvent::SET_DATA, Argument::type(CalendarEvent::class))
            ->shouldBeCalled()
            ->willReturn($calendarEvent);

        $calendarEvent->getEvents()->shouldBeCalled()->willReturn($events);

        $serializer->serialize($events)->shouldBeCalled()->willReturn($json);

        $this->getData($startDate, $endDate, [])->shouldReturn($json);
    }
}
