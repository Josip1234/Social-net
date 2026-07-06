<?php
namespace Classes;
class Body{
    const OPEN_BODY="<body>";
    
    public function openBody():string{
        return self::OPEN_BODY;
    }
}