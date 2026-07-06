<?php
namespace Classes;
class Lists{
    const OPEN_UNORDERED_LIST="<ul>";
    const CLOSE_UNORDERED_LIST="</ul>";
    const OPEN_LIST_ITEM="<li>";
    const CLOSE_LIST_ITEM="</li>";
    const OPEN_ORDERED_LIST="<ol>";
    const CLOSE_ORDERED_LIST="</ol>";
    const OPEN_DESCRIPTION_LIST="<dl>";
    const CLOSE_DESCRIPTION_LIST="</dl>";
    const OPEN_TERM="<dt>";
    const CLOSE_TERM="</dt>";
    const OPEN_TERM_DESCRIBE="<dd>";
    const CLOSE_TERM_DESCRIBE="</dd>";

    public function __construct(public string $listType, public array $items)
    {
        $this->listType=$listType;
        $this->items=(count($items)==0)?[]:$items;
    }

    public function createUnorderedList():string{
         $list="";
         $list.=self::OPEN_UNORDERED_LIST;
         foreach ($this->items as $value) {
            $list.=self::OPEN_LIST_ITEM;
            $list.=$value;
            $list.=self::CLOSE_LIST_ITEM;
         };
         $list.=self::CLOSE_UNORDERED_LIST;
         return $list;
    }
}
