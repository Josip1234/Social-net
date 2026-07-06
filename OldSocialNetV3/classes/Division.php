<?php 
namespace Classes;
class Division{
    const OPEN_DIV="<div";
    const ARROW_RIGHT=">";
    const CLASS_TAG="class=";
    const ID_TAG = "id=";
    const CLOSE_DIV="</div>";

    public function __construct(private array $classes)
    {
        //if array is empty init empty array same for the array of ids
        $this->classes=(count($classes)==0)?[]:$classes;

    } 

    public function createClasses():string{
        $index=0;
        //final strting to merge
        $classes="";
        //string of classes
        $classes="";
        //string of ids
        $ids="";
        $sizeOfClassArray=count($this->classes);

        if($sizeOfClassArray==0){
             $classes="";      
        }else{
            $classes.=self::CLASS_TAG."\"";
            foreach ($this->classes as $value) {
       
                $index++;
                $classes.=$value;
                if($index==$sizeOfClassArray) $classes.=""."\"";
                else $classes.=" ";
            }
          
        }
        
        return " ".$classes;
    }

    public function printDivision(Lists $lists):string{
        $div="";
        $div.=self::OPEN_DIV;
        $div.=$this->createClasses();
        $div.=self::ARROW_RIGHT;
        $div.=$lists->createUnorderedList();
        $div.=self::CLOSE_DIV;
        return $div;
    }

}