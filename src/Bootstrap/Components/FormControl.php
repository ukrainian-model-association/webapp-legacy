<?php

namespace App\Bootstrap\Components;

use App\Bootstrap\Core\ClassList;

class FormControl
{
    const TYPE_TEXT  = 'text';
    const TYPE_EMAIL = 'email';
    const TYPE_TEL   = 'tel';

    /** @var string */
    private $type;

    /** @var ClassList */
    private $classList;

    /** @var string */
    private $name;

    /** @var string */
    private $placeholder;

    /** @var string */
    private $label;

    /** @var bool */
    private $required;

    private $aria;

    /**
     * FormControl constructor.
     *
     * @param string $name
     * @param string $label
     * @param string $type
     */
    public function __construct($name, $label, $type)
    {
        $this
            ->setType($type)
            ->setClassList(['form-control'])
            ->setName($name)
            ->setPlaceholder($label)
            ->setLabel($label);
    }

    /**
     * @param string $name
     * @param string $label
     * @param string $type
     *
     * @return self
     */
    public static function create($name, $label, $type = self::TYPE_TEXT)
    {
        return new self($name, $label, $type);
    }

    public function __toString()
    {
        $attrs = [
            'class' => $this->getClassList(),
            'type'  => $this->getType(),
            'name'  => $this->getName(),
        ];

        if ($this->getPlaceholder()) {
            $attrs['placeholder'] = $this->getPlaceholder();
        }

        if ($this->getLabel()) {
            $attrs['aria-label'] = $this->getLabel();
        }

        if ($this->isRequired()) {
            $attrs['required'] = 'required';
        }

        $attrs = array_map([$this, 'handleAttribute'], array_keys($attrs), array_values($attrs));

        return sprintf('<input %s/>', implode(' ', $attrs));
    }

    /**
     * @return ClassList
     */
    public function getClassList()
    {
        return $this->classList;
    }

    /**
     * @param ClassList|array $classList
     *
     * @return FormControl
     */
    public function setClassList($classList = [])
    {
        if (is_array($classList)) {
            $classList = new ClassList($classList);
        }

        $this->classList = $classList;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return FormControl
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return FormControl
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     *
     * @return FormControl
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return FormControl
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function isRequired()
    {
        return (bool) $this->required;
    }

    /**
     * @param bool $required
     *
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = (bool) $required;

        return $this;
    }

    public function setAria($key, $value)
    {

    }

    private function handleAttribute($key, $value)
    {
        return sprintf('%s="%s"', $key, $value);
    }
}
