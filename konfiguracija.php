<?php
include("dbconn.php");
class Tema
{
    private $id;
    private $nazivKorisnika;
    private $brojteme;
    private $nazivTeme;
    
    
    
    
    public function __construct(int $brojteme=0,string $nazivKorisnika,string $nazivTeme){
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
class Podtema extends Tema{
    private $id;
    private $brojPodteme;
    private $nazivPodteme;
    private $brojteme;
    public function __construct(string $nazivPodteme){
        
        $this->id=rand();
        $this->brojPodteme=rand();
        $this->nazivPodteme=$nazivPodteme;
       
    }
    public function ispis(){
        
        echo $this->id."\n";
        echo $this->brojPodteme."\n";
        echo $this->nazivPodteme."\n";
    }
}
$tema=new Tema(0,"Josip", "MojaTema");
$podtema=new Podtema("Blabla");
echo $tema->ispis().$podtema->ispis();

?>

