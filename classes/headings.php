<?php
class Heading{
  private $h2;
  const OPEN_H2="<h2>";
  const CLOSE_H2="</h2>";
  
  public function __construct($h2) {
    $this->h2 = $h2;
  }

  public function getH2() {return $this->h2;}

	public function setH2( $h2): void {$this->h2 = $h2;}

	public function print_h2(){
        echo Heading::OPEN_H2;
        echo $this->getH2();
        echo Heading::CLOSE_H2;
    }

}
?>