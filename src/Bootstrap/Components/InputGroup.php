<?php

namespace App\Bootstrap\Components;

class InputGroup
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $label;

    /** @var array */
    private $options;

    public static function create()
    {
        return new self();
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setName()
    {
        return $this;
    }

    public function setData($options)
    {
        $this->options = $options;

        return $this;
    }

    public function render()
    {
        return <<<HTML
<div class="input-group input-group-sm mb-3">
    <div class="input-group-prepend" style="width: 15%">
        <label class="input-group-text w-100" for="statusType">{$this->label}</label>
    </div>
    <select class="custom-select custom-select-sm" name="{$this->name}" id="{$this->id}">
        <option value="0">&mdash;</option>
    </select>
</div>
HTML;
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }
}
