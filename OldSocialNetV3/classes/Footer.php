<?php
namespace Classes;
class Footer extends Body{
    const CLOSE_BODY="</body>";
    const CLOSE_HTML="</html>";

    public function closeBodyAndHtml(Division $division,Lists $lists,Nav $nav):void{
         if($division->createClasses()!="" && $nav->returnNavElement()!=""){
            echo parent::openBody().$division->printDivisionWithinNavTag($nav).self::CLOSE_BODY.self::CLOSE_HTML;
        }
        elseif($division->createClasses()!=""){
            echo parent::openBody().$division->printDivision($lists).self::CLOSE_BODY.self::CLOSE_HTML;
        }
        elseif($nav->returnNavElement()!=""){
              echo parent::openBody().$nav->returnNavElement().self::CLOSE_BODY.self::CLOSE_HTML;
        }
        else{
        
            echo parent::openBody().self::CLOSE_BODY.self::CLOSE_HTML;
        }
        
    }
}