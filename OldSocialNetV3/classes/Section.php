<?php

namespace Classes;

class Section
{
    const OPEN_SECTION = "<section>";
    const CLOSE_SECTION = "</section>";

    public function __construct(private array $sectionContent)
    {
        $this->sectionContent = ((int)count($sectionContent) == 0) ? [] : $sectionContent;
    }

    //get section as a string
    public function getSection()
    {
        $section = "";

        foreach ($this->sectionContent as $value) {
            $section .= self::OPEN_SECTION;
            $section .= $value;
            $section .= self::CLOSE_SECTION;
        }


        return $section;
    }
}
