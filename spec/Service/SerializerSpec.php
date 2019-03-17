<?php

namespace spec\Toiba\FullCalendarBundle\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Service\Serializer;

class SerializerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Serializer::class);
    }

    public function it_serialzes_data_successfully(Event $event1, Event $event2)
    {
        $event1->toArray()->shouldBeCalled()->willReturn(
            [
                'title' => 'Event 1',
                'start' => '20/01/2015',
                'end' => '21/01/2015',
            ]
        );
        $event2->toArray()->shouldBeCalled()->willReturn(
            [
                'title' => 'Event 2',
                'start' => '21/01/2015',
                'end' => '22/01/2015',
            ]
        );

        $this
            ->serialize([$event1, $event2])
            ->shouldReturn('[{"title":"Event 1","start":"20\/01\/2015","end":"21\/01\/2015"},{"title":"Event 2","start":"21\/01\/2015","end":"22\/01\/2015"}]');
    }

    public function it_serialzes_should_return_emtpy_if_events_are_empty()
    {
        $this->serialize([])->shouldReturn('[]');
    }
}
