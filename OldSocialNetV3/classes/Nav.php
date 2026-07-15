<?php
namespace Classes;
class Nav{
    const NAV_OPEN="<nav>";
    const NAV_CLOSE="</nav>";

    //items can be for example list of url items or just urls
    public function __construct(private string $items)
    {
        $this->$items=(strlen($items)===0)?"":$items;
    }

    public function returnNavElement():string{
        $navElement="";
        $navElement.=self::NAV_OPEN;
        $navElement.=$this->items;
        $navElement.=self::NAV_CLOSE;
        return $navElement;
    }
 
}