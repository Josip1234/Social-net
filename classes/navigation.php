<?php
class Navigation
{
    private $nav_name;
    private $nav_script_name;
    private $tag;
    public function __construct($nav_name,  $nav_script_name,  $tag)
    {
        $this->nav_name = $nav_name;
        $this->nav_script_name = $nav_script_name;
        $this->tag = $tag;
    }
    public function getNavName()
    {
        return $this->nav_name;
    }

    public function getNavScriptName()
    {
        return $this->nav_script_name;
    }

    public function getTag()
    {
        return $this->tag;
    }
    public function setNavName($nav_name): void
    {
        $this->nav_name = $nav_name;
    }

    public function setNavScriptName($nav_script_name)
    {
        $this->nav_script_name = $nav_script_name;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}
