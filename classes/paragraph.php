<?php 

class Paragraph{
const OPEN_P="<p>";
const CLOSE_P="</p>";
const P_WITH_ID_S="<p id='s'>";
private $paragraph_value;

public function __construct( $paragraph_value){$this->paragraph_value = $paragraph_value;}
	public function getParagraphValue() {return $this->paragraph_value;}
public function setParagraphValue( $paragraph_value): void {$this->paragraph_value = $paragraph_value;}

	public function print_paragraphs_values(){
        echo Paragraph::OPEN_P;
        echo $this->getParagraphValue();
        echo Paragraph::CLOSE_P;
    }
	

}



?>