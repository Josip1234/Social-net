<?php

namespace Classes;

class Division
{
    const OPEN_DIV = "<div";
    const ARROW_RIGHT = ">";
    const CLASS_TAG = "class=";
    const ID_TAG = "id=";
    const CLOSE_DIV = "</div>";

    public function __construct(private array $classes)
    {
        //if array is empty init empty array same for the array of ids
        $this->classes = (count($classes) == 0) ? [] : $classes;
    }

    public function createClasses(): string
    {
        $returnValue = "";
        $index = 0;
        //final strting to merge
        $classes = "";
        //string of classes
        $classes = "";
        //string of ids
        $ids = "";

        //if first value is empty in array and array count is 1 (only one element init array) retrun value should be empty
        if ($this->classes[0] == "" && count($this->classes) === 1) {
            $returnValue = "";
        } else {
            $sizeOfClassArray = count($this->classes);

            if ($sizeOfClassArray == 0) {
                $classes = "";
            } else {
                $classes .= self::CLASS_TAG . "\"";
                foreach ($this->classes as $value) {

                    $index++;
                    $classes .= $value;
                    if ($index == $sizeOfClassArray) $classes .= "" . "\"";
                    else $classes .= " ";
                }
            }
            $returnValue = " " . $classes;
        }

        return $returnValue;
    }
    //print divison with unordered list
    public function printDivision(Lists $lists): string
    {
        $div = "";
        //do not create division if first value is empty in array and array count is 1 (only one element init array)
        if ($this->classes[0] == "" && count($this->classes) === 1) {
            $div = "";
        } else {
            $div .= self::OPEN_DIV;
            $div .= $this->createClasses();
            $div .= self::ARROW_RIGHT;
            $div .= $lists->createUnorderedList();
            $div .= self::CLOSE_DIV;
        }
        return $div;
    }
    //list parameter is extra since we have a list of items in nav already
    //print division with nav class
    public function printDivisionWithinNavTag(Nav $nav)
    {
        $div = "";
        //do not create division if first value is empty in array and array count is 1 (only one element init array)
        if ($this->classes[0] == "" && count($this->classes) === 1) {
            $div = "";
        } else {
            $div .= self::OPEN_DIV;
            $div .= $this->createClasses();
            $div .= self::ARROW_RIGHT;
            $div .= $nav->returnNavElement();
            $div .= self::CLOSE_DIV;
        }
        return $div;
    }
    //this function will print additional divisions inside main division, main division must exists,
    //navigation must exists, sections are optional
    public function printDivisionWithInsideDivisions(array $additionalDivisions, Nav $nav, array $sections=[]): string
    {
        $div = "";
        //do not create division if first value is empty in array and array count is 1 (only one element init array)
        if ($this->classes[0] == "" && count($this->classes) === 1) {
            $div = "";
        } else {
            $div .= self::OPEN_DIV;
            $div .= $this->createClasses();
            $div .= self::ARROW_RIGHT;
            $div .= $nav->returnNavElement();
            //here we will write additional divisions
            foreach ($additionalDivisions as $value) {
                //additional divisions must be a type of object 
                if (gettype($value) === "object") {
                    //value must be of type division
                    if ($value instanceof Division) {
                        //make divisions inside div
                        $div .= self::OPEN_DIV;
                        $div .= $value->createClasses();
                        $div .= self::ARROW_RIGHT;
                        //add sections into division if they are defined
                        if(count($sections)>0){
                                 $section = new Section($sections);
                          
                                  $div.=$section->getSection();
                            
                        };
                        $div .= self::CLOSE_DIV;
                    }
                }
            }

            $div .= self::CLOSE_DIV;
        }
        return $div;
    }
    //get class object
    public function getClasses(): array
    {
        return $this->classes;
    }
}
