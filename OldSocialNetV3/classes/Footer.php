<?php
namespace Classes;
class Footer extends Body{
    const CLOSE_BODY="</body>";
    const CLOSE_HTML="</html>";

    public function closeBodyAndHtml(Division $division,Lists $lists):void{
        if($division!=null){
            echo parent::openBody().$division->printDivision($lists).self::CLOSE_BODY.self::CLOSE_HTML;
        }else{
            echo parent::openBody().self::CLOSE_BODY.self::CLOSE_HTML;
        }
        
    }
}