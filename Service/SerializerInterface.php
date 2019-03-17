<?php

namespace Toiba\FullCalendarBundle\Service;

use Toiba\FullCalendarBundle\Entity\Event;

interface SerializerInterface
{
    /**
     * @param Event[] $events
     *
     * @return string json
     */
    public function serialize(array $events): string;
}
