<?php
class Tema
{
    private $id;
    private $nazivKorisnika;
    private $brojteme;
    private $nazivTeme;
    
    public function __construct(string $nazivKorisnika,string $nazivTeme){
        $this->id=rand();
        $this->nazivKorisnika=$nazivKorisnika;
        $this->brojteme=rand();
        $this->nazivTeme=$nazivTeme;
    }
   public function ispis(){
       echo $this->id."\n";
       echo $this->nazivKorisnika."\n";
       echo $this->brojteme."\n";
       echo $this->nazivTeme."\n";
   }
    
}

$tema=new Tema("Josip", "MojaTema");
$tema->ispis();
?>

