<?php

namespace Toiba\FullCalendarBundle\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class Calendar
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param SerializerInterface      $serializer
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        SerializerInterface $serializer,
        EventDispatcherInterface $dispatcher
    ) {
        $this->serializer = $serializer;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @param array              $filters
     *
     * @return string json
     */
    public function getData(
        \DateTimeInterface $startDate,
        ?\DateTimeInterface $endDate,
        array $filters = []
    ): array {
        /** @var CalendarEvent $event */
        $event = $this->dispatcher->dispatch(
            CalendarEvent::SET_DATA,
            new CalendarEvent($startDate, $endDate, $filters)
        );

        return $this->serializer->serialize($event->getEvents());
    }
}
