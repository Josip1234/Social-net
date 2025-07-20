<?php
class Form
{
    const OPEN_SELECT_WITH_ONCHANGE_EVENT = "<select id='selected' onChange='selected(this.value)'>";
    const OPEN_EMPTY_OPTION_WITH_ID = " <option id='Select'>";
    const CLOSE_OPTION = "</option>";
    const OPEN_OPTION_WITH_ID_NEEDED = "<option id='";
    private $option_id;
    const CLOSE_OPTION_WITH_ID_NEEDED = "'>";
    private $option_value;
    const CLOSE_SELECT = "</select>";
    private $option_values;

    public function __construct($option_id,  $option_value,  $option_values)
    {
        $this->option_id = $option_id;
        $this->option_value = $option_value;
        $this->option_values = $option_values;
    }
    public function getOptionId()
    {
        return $this->option_id;
    }

    public function getOptionValue()
    {
        return $this->option_value;
    }

    public function getOptionValues()
    {
        return $this->option_values;
    }

    public function setOptionId($option_id): void
    {
        $this->option_id = $option_id;
    }

    public function setOptionValue($option_value): void
    {
        $this->option_value = $option_value;
    }

    public function setOptionValues($option_values): void
    {
        $this->option_values = $option_values;
    }

    public function print_option_values_only_with_id_s(){
        foreach ($this->getOptionValues() as $value) {
            $this->setOptionId($value);
            $this->setOptionValue($this->getOptionId());
            $option=FORM::OPEN_OPTION_WITH_ID_NEEDED.$this->getOptionId().FORM::CLOSE_OPTION_WITH_ID_NEEDED.$this->getOptionValue().FORM::CLOSE_OPTION;
            echo $option;
        }
    }
}
