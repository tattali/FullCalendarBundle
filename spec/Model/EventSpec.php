<?php

namespace spec\Toiba\FullCalendarBundle\Entity;

use PhpSpec\ObjectBehavior;
use Toiba\FullCalendarBundle\Entity\Event;

class EventSpec extends ObjectBehavior
{
    private $title = 'Title';
    private $startDate;

    public function let()
    {
        $this->startDate = new \DateTime();

        $this->beAnInstanceOf(EventTesteable::class);
        $this->beConstructedWith($this->title, $this->startDate, $this->endDate);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Event::class);
    }

    public function it_has_require_values()
    {
        $this->getTitle()->shouldReturn($this->title);
        $this->getStartDate()->shouldReturn($this->startDate);
    }

    public function it_should_convert_its_values_in_to_array()
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

    public function it_retunrs_defualt_array_values()
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
