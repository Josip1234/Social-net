<?php
class Url
{
    const OPEN_HREF_TAG = "<a href='";
    private $value; //TREBA DODATI +' 
    const CLOSE_HREF_TAG = "</a>";
    const OPEN_TARGET = "target='";
    private $target_value;
    const OPEN_CLASS = "class='";
    private $class; //TREBA DODATI +'
    const OPEN_BUTTON = "<button";
    const CLOSE_BUTTON = "</button>";
    const CLOSE_FIRST_PART_ELEMENT = ">";

    public function __construct($value, $class)
    {
        $this->value = $value;
        $this->target_value = array("_blank'","_self'","_parent'","_top'","framename'");
        $this->class = $class;
    }
    public function getValue()
    {
        return $this->value;
    }

    public function getTargetValue()
    {
        return $this->target_value;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }
}
