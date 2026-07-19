<?php
namespace Classes;
class Footer extends Body{
    const CLOSE_BODY="</body>";
    const CLOSE_HTML="</html>";

    public function closeBodyAndHtml(Division $containerDivision,Lists $lists,Nav $nav,array $additionalDivs=[],array $sections=[]):void{
        //if there is additional divs inside main container
        if(count($additionalDivs)>0 && $nav->returnNavElement()!="" && (int)count($sections)>0){
             echo parent::openBody().$containerDivision->printDivisionWithInsideDivisions($additionalDivs,$nav,$sections).self::CLOSE_BODY.self::CLOSE_HTML;
        }elseif (count($additionalDivs)>0 && $nav->returnNavElement()!="") {
        
        echo parent::openBody().$containerDivision->printDivisionWithInsideDivisions($additionalDivs,$nav).self::CLOSE_BODY.self::CLOSE_HTML;
 
        }
        else{
         if($containerDivision->createClasses()!="" && $nav->returnNavElement()!=""){
            echo parent::openBody().$containerDivision->printDivisionWithinNavTag($nav).self::CLOSE_BODY.self::CLOSE_HTML;
        }
        elseif($containerDivision->createClasses()!=""){
            echo parent::openBody().$containerDivision->printDivision($lists).self::CLOSE_BODY.self::CLOSE_HTML;
        }
        elseif($nav->returnNavElement()!=""){
              echo parent::openBody().$nav->returnNavElement().self::CLOSE_BODY.self::CLOSE_HTML;
        }
        else{
        
            echo parent::openBody().self::CLOSE_BODY.self::CLOSE_HTML;
        }
        }
        
    }
}