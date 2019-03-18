<?php

namespace spec\Toiba\FullCalendarBundle\Entity;

use PhpSpec\ObjectBehavior;
use Toiba\FullCalendarBundle\Entity\Event;

class EventSpec extends ObjectBehavior
{
    private $title = 'Title';
    private $startDate;
    private $endDate = null;

    public function let()
    {
        $this->startDate = new \DateTime();
        $this->endDate = new \DateTime();

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
        $this->getEndDate()->shouldReturn($this->endDate);
    }

    public function it_should_convert_its_values_in_to_array()
    {
        $id = '3516514';
        $url = 'www.url.com';
        $bgColor = 'red';
        $textColor = 'blue';
        $className = 'name';
        $endDate = new \DateTime();
        $rendering = 'string';
        $constraint = ['foo' => 'bar'];
        $source = 'source';
        $color = 'yellow';
        $fieldName = 'description';
        $fieldValue = 'bla bla bla';

        $this->setId($id);
        $this->setUrl($url);
        $this->setBackgroundColor($bgColor);
        $this->setTextColor($textColor);
        $this->setClassName($className);
        $this->setEndDate($endDate);
        $this->setRendering($rendering);
        $this->setConstraint($constraint);
        $this->setSource($source);
        $this->setColor($color);
        $this->setCustomField($fieldName, $fieldValue);

        $this->setAllDay(false);
        $this->setEditable(false);
        $this->setStartEditable(false);
        $this->setDurationEditable(false);
        $this->setOverlap(true);

        $this->setCustomField('be-removed', 'value');
        $this->removeCustomField('be-removed');

        $this->removeCustomField('no-found-key')->shouldReturn(null);

        $this->getCustomFieldValue($fieldName, $fieldValue)->shouldReturn($fieldValue);

        $this->toArray()->shouldReturn(
            [
                'title' => $this->title,
                'start' => $this->startDate->format('Y-m-d\\TH:i:sP'),
                'allDay' => false,
                'editable' => false,
                'startEditable' => false,
                'durationEditable' => false,
                'overlap' => true,
                'id' => $id,
                'url' => $url,
                'backgroundColor' => $bgColor,
                'textColor' => $textColor,
                'className' => $className,
                'end' => $this->endDate->format('Y-m-d\\TH:i:sP'),
                'rendering' => $rendering,
                'constraint' => $constraint,
                'source' => $source,
                'color' => $color,
                $fieldName => $fieldValue,
            ]
        );
    }
}
