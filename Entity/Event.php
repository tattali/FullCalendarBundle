<?php

namespace Toiba\FullCalendarBundle\Entity;

class Event
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var bool
     */
    protected $allDay = true;

    /**
     * @var \DateTimeInterface
     */
    protected $startDate;

    /**
     * @var \DateTimeInterface
     */
    protected $endDate = null;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var bool
     */
    protected $editable = false;

    /**
     * @var bool
     */
    protected $startEditable = false;

    /**
     * @var bool
     */
    protected $durationEditable = false;

    /**
     * @var string
     */
    protected $rendering;

    /**
     * @var bool
     */
    protected $overlap = true;

    /**
     * @var int
     */
    protected $constraint;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var string
     */
    protected $backgroundColor;

    /**
     * @var string
     */
    protected $textColor;

    /**
     * @var array
     */
    protected $customFields = [];

    /**
     * @param string             $title
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     */
    public function __construct(
        ?string $title,
        \DateTimeInterface $start,
        ?\DateTimeInterface $end = null
    ) {
        $this->setTitle($title);
        $this->setStartDate($start);
        $this->setEndDate($end);
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function isAllDay(): bool
    {
        return $this->allDay;
    }

    /**
     * @param bool $allDay
     */
    public function setAllDay(bool $allDay): void
    {
        $this->allDay = $allDay;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     */
    public function setStartDate(?\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     */
    public function setEndDate(?\DateTimeInterface $endDate = null): void
    {
        if (null !== $endDate) {
            $this->allDay = false;
        }
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getClassName(): ?string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(?string $className): void
    {
        $this->className = $className;
    }

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->editable;
    }

    /**
     * @param bool $editable
     */
    public function setEditable(bool $editable): void
    {
        $this->editable = $editable;
    }

    /**
     * @return bool
     */
    public function isStartEditable(): bool
    {
        return $this->startEditable;
    }

    /**
     * @param bool $startEditable
     */
    public function setStartEditable(bool $startEditable): void
    {
        $this->startEditable = $startEditable;
    }

    /**
     * @return bool
     */
    public function isDurationEditable(): bool
    {
        return $this->durationEditable;
    }

    /**
     * @param bool $durationEditable
     */
    public function setDurationEditable(bool $durationEditable): void
    {
        $this->durationEditable = $durationEditable;
    }

    /**
     * @return string
     */
    public function getRendering(): ?string
    {
        return $this->rendering;
    }

    /**
     * @param string $rendering
     */
    public function setRendering(?string $rendering): void
    {
        $this->rendering = $rendering;
    }

    /**
     * @return bool
     */
    public function isOverlap(): bool
    {
        return $this->overlap;
    }

    /**
     * @param bool $overlap
     */
    public function setOverlap(bool $overlap): void
    {
        $this->overlap = $overlap;
    }

    /**
     * @return int
     */
    public function getConstraint(): ?int
    {
        return $this->constraint;
    }

    /**
     * @param int $constraint
     */
    public function setConstraint($constraint): void
    {
        $this->constraint = $constraint;
    }

    /**
     * @return string
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(?string $source): void
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    /**
     * @param string $backgroundColor
     */
    public function setBackgroundColor(?string $backgroundColor): void
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return string
     */
    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    /**
     * @param string $textColor
     */
    public function setTextColor(?string $textColor): void
    {
        $this->textColor = $textColor;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function setCustomField($name, $value): void
    {
        $this->customFields[$name] = $value;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getCustomFieldValue($name)
    {
        return $this->customFields[$name];
    }

    /**
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function removeCustomField($name)
    {
        if (!isset($this->customFields[$name]) && !array_key_exists($name, $this->customFields)) {
            return null;
        }

        $removed = $this->customFields[$name];
        unset($this->customFields[$name]);

        return $removed;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $event = [];

        $event['title'] = $this->getTitle();
        $event['start'] = $this->getStartDate()->format('Y-m-d\\TH:i:sP');
        $event['allDay'] = $this->isAllDay();
        $event['editable'] = $this->isEditable();
        $event['startEditable'] = $this->isStartEditable();
        $event['durationEditable'] = $this->isDurationEditable();
        $event['overlap'] = $this->isOverlap();

        $event['id'] = $this->getId();
        $event['url'] = $this->getUrl();
        $event['backgroundColor'] = $this->getBackgroundColor();
        $event['textColor'] = $this->getTextColor();
        $event['className'] = $this->getClassName();
        $event['end'] = $this->getEndDate()->format('Y-m-d\\TH:i:sP');
        $event['rendering'] = $this->getRendering();
        $event['constraint'] = $this->getConstraint();
        $event['source'] = $this->getSource();
        $event['color'] = $this->getColor();

        foreach ($this->getCustomFields() as $field => $value) {
            $event[$field] = $value;
        }

        return $event;
    }
}
