<?php

namespace spec\Toiba\FullCalendarBundle\Service;

use PhpSpec\ObjectBehavior;
use Toiba\FullCalendarBundle\Entity\Event;

class SerializerSpec extends ObjectBehavior
{
    public function itIsInitializable()
    {
        $this->shouldHaveType('Toiba\FullCalendarBundle\Service\Serializer');
    }

    public function itSerialzesDataSuccessfully(Event $event1, Event $event2)
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

    public function itSerialzesShouldReturnEmtpyIfEventsAreEmpty()
    {
        $this->serialize([])->shouldReturn('[]');
    }
}
