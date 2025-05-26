<?php 
//ovdje ćemo generirati konstante za klasični html header i pripadajuće elemente
//poput css-a
class Header{
    const START_HTML ="<!DOCTYPE html>";
    const HTML_LANG="<html lang='en'>";
    const OPEN_HEADER="<head>";
    const CLOSE_HEADER="</head>";
    const META_CHARSET="<meta charset='UTF-8'>";
    const VIEWPORT="<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    const MAIN_CSS="<link rel='stylesheet' href='css/stil.css'>";
    const OPEN_TITLE="<title>";
    const CLOSE_TITLE="</title>";
}
//klasa koja služi za postavljanje naslova u headeru i ispisivanje istoga
class Title{
    public $title;
    public function __construct( $title){$this->title = $title;}
	public function getTitle() {return $this->title;}
public function setTitle( $title): void {$this->title = $title;}
//ispiši title header
public function printTitle(){
    
    echo Header::OPEN_TITLE.$this->getTitle().Header::CLOSE_TITLE;
}
	
	
}

?>