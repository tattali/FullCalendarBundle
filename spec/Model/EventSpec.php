<?php

namespace spec\Toiba\FullCalendarBundle\Entity;

use PhpSpec\ObjectBehavior;
use Toiba\FullCalendarBundle\Entity\Event;

class EventSpec extends ObjectBehavior
{
    private $title = 'Title';
    private $startDate;
    private $endDate;

    public function let()
    {
        $this->startDate = new \DateTime();
        $this->endDate = new \DateTime();

        $this->beAnInstanceOf(EventTesteable::class);
        $this->beConstructedWith($this->title, $this->startDate, $this->endDate);
    }

    public function itIsInitializable()
    {
        $this->shouldHaveType(Event::class);
    }

    public function itHasRequireValues()
    {
        $this->getTitle()->shouldReturn($this->title);
        $this->getStartDate()->shouldReturn($this->startDate);
        $this->getEndDate()->shouldReturn($this->endDate);
    }

    public function itShouldConvertItsValuesInToArray()
    {
        $id = '3516514';
        $url = 'www.url.com';
        $bgColor = 'red';
        $txtColor = 'blue';
        $className = 'name';
        $endDate = new \DateTime();
        $rendering = 'string';
        $constraint = 'foo';
        $source = 'source';
        $color = 'yellow';
        $fieldName = 'description';
        $fieldValue = 'bla bla bla';

        $this->setId($id);
        $this->setUrl($url);
        $this->setBackgroundColor($bgColor);
        $this->setTextColor($txtColor);
        $this->setClassName($className);
        $this->setEndDate($endDate);
        $this->setRendering($rendering);
        $this->setConstraint($constraint);
        $this->setSource($source);
        $this->setColor($color);
        $this->setCustomField($fieldName, $fieldValue);

        $this->toArray()->shouldReturn(
            [
                'title' => $this->title,
                'start' => $this->startDate->format('Y-m-d\\TH:i:sP'),
                'allDay' => true,
                'editable' => false,
                'startEditable' => false,
                'durationEditable' => false,
                'overlap' => true,
                'id' => $id,
                'url' => $url,
                'backgroundColor' => $bgColor,
                'textColor' => $txtColor,
                'className' => $className,
                'end' => $endDate->format('Y-m-d\\TH:i:sP'),
                'rendering' => $rendering,
                'constraint' => $constraint,
                'source' => $source,
                'color' => $color,
                'description' => 'bla bla bla',
            ]
        );
    }

    public function itReturnsDefualtArrayValues()
    {
        $this->toArray()->shouldReturn(
            [
                'title' => $this->title,
                'start' => $this->startDate->format('Y-m-d\\TH:i:sP'),
                'allDay' => true,
                'editable' => false,
                'startEditable' => false,
                'durationEditable' => false,
                'overlap' => true,
            ]
        );
    }
}

class EventTesteable extends Event
{
}
