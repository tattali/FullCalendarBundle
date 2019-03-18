<?php

namespace Toiba\FullCalendarBundle\Entity;

class Event
{
    /**
     * @var int|string
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
    protected $url = null;

    /**
     * @var string
     */
    protected $className = null;

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
    protected $rendering = null;

    /**
     * @var bool
     */
    protected $overlap = true;

    /**
     * @var array
     */
    protected $constraint = null;

    /**
     * @var string
     */
    protected $source = null;

    /**
     * @var string
     */
    protected $color = null;

    /**
     * @var string
     */
    protected $backgroundColor = null;

    /**
     * @var string
     */
    protected $textColor = null;

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
        string $title,
        \DateTimeInterface $start,
        \DateTimeInterface $end = null
    ) {
        $this->setTitle($title);
        $this->setStartDate($start);
        $this->setEndDate($end);
    }

    /**
     * @return null|int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null|int|string $id
     */
    public function setId($id = null): void
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
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
     * @return null|\DateTimeInterface
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     */
    public function setStartDate(\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return null|\DateTimeInterface
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     */
    public function setEndDate(\DateTimeInterface $endDate = null): void
    {
        if (null !== $endDate) {
            $this->allDay = false;
        }
        $this->endDate = $endDate;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     */
    public function setUrl(?string $url = null): void
    {
        $this->url = $url;
    }

    /**
     * @return null|string
     */
    public function getClassName(): ?string
    {
        return $this->className;
    }

    /**
     * @param null|string $className
     */
    public function setClassName(?string $className = null): void
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
     * @return null|string
     */
    public function getRendering(): ?string
    {
        return $this->rendering;
    }

    /**
     * @param null|string $rendering
     */
    public function setRendering(?string $rendering = null): void
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
     * @return null|array
     */
    public function getConstraint(): ?array
    {
        return $this->constraint;
    }

    /**
     * @param null|array $constraint
     */
    public function setConstraint(?array $constraint = null): void
    {
        $this->constraint = $constraint;
    }

    /**
     * @return null|string
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param null|string $source
     */
    public function setSource(?string $source = null): void
    {
        $this->source = $source;
    }

    /**
     * @return null|string
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param null|string $color
     */
    public function setColor(?string $color = null): void
    {
        $this->color = $color;
    }

    /**
     * @return null|string
     */
    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    /**
     * @param null|string $backgroundColor
     */
    public function setBackgroundColor(?string $backgroundColor = null): void
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return null|string
     */
    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    /**
     * @param null|string $textColor
     */
    public function setTextColor(?string $textColor = null): void
    {
        $this->textColor = $textColor;
    }

    /**
     * @param string $name
     * @param $value
     *
     * @return mixed
     */
    public function setCustomField(string $name, $value): void
    {
        $this->customFields[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getCustomFieldValue(string $name)
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
     * @param string $name
     *
     * @return mixed
     */
    public function removeCustomField(string $name)
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

        if (null !== $this->getId()) {
            $event['id'] = $this->getId();
        }

        if (null !== $this->getUrl()) {
            $event['url'] = $this->getUrl();
        }

        if (null !== $this->getBackgroundColor()) {
            $event['backgroundColor'] = $this->getBackgroundColor();
        }

        if (null !== $this->getTextColor()) {
            $event['textColor'] = $this->getTextColor();
        }

        if (null !== $this->getClassName()) {
            $event['className'] = $this->getClassName();
        }

        if (null !== $this->getEndDate()) {
            $event['end'] = $this->getEndDate()->format('Y-m-d\\TH:i:sP');
        }

        if (null !== $this->getRendering()) {
            $event['rendering'] = $this->getRendering();
        }

        if (null !== $this->getConstraint()) {
            $event['constraint'] = $this->getConstraint();
        }

        if (null !== $this->getSource()) {
            $event['source'] = $this->getSource();
        }

        if (null !== $this->getColor()) {
            $event['color'] = $this->getColor();
        }

        foreach ($this->getCustomFields() as $field => $value) {
            $event[$field] = $value;
        }

        return $event;
    }
}
