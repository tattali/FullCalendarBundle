<?php

namespace Toiba\FullCalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event as EventDispatcher;
use Toiba\FullCalendarBundle\Entity\Event;

class CalendarEvent extends EventDispatcher
{
    const SET_DATA = 'fullcalendar.set_data';

    /**
     * @var \DateTimeInterface
     */
    protected $start;

    /**
     * @var \DateTimeInterface
     */
    protected $end;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var Event[]
     */
    protected $events = [];

    /**
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @param array              $filters
     */
    public function __construct(
        \DateTimeInterface $start,
        \DateTimeInterface $end,
        array $filters
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->filters = $filters;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param Event $event
     *
     * @return $this
     */
    public function addEvent(Event $event): self
    {
        if (!in_array($event, $this->events, true)) {
            $this->events[] = $event;
        }

        return $this;
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
