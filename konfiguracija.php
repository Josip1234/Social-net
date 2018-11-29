<?php
class Forum {
    private $korisnik;
    
    public  function setKorisnik($korisnik){
        $this->korisnik=$korisnik;
    }
    public function getKorisnik(){
        return $this->korisnik;
    }
    
}
class Tema extends Forum{
    private $id;
    private $brojteme;
    private $nazivTeme;

    
    public function __construct(string $nazivTeme){
        $this->id=rand();
        $this->brojteme=rand();
        $this->nazivTeme=$nazivTeme;
        
    }
    
    public function ispisiTrenutneTeme(){
		
		 
        echo "<li><a href='#podteme' onClick='displaySubtopics()'> "."Broj teme:".$this->getbrojTeme()."Korisnik:".$this->getKorisnik()." Naziv teme: ".$this->nazivTeme."</a></li>";
		
		
    
       
    }
    public function setTema($nazivTeme){
        $this->nazivTeme=$nazivTeme;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getbrojTeme(){
        return $this->brojteme;
    }
    public function getNazivTeme(){
        return $this->nazivTeme;
    }
	public function setBroj($broj){
       $this->brojteme=$broj;
    }
  
  
}

class Podtema extends Tema{
    private $id;
    private $brojPodteme;
    private $nazivPodteme;
    
    public function __construct(string $nazivPodteme){
        
        $this->id=rand();
        $this->brojPodteme=rand();
        $this->nazivPodteme=$nazivPodteme;
        
       
    }
	
    public function ispis(){
        echo "Korisnik ".$this->getKorisnik(). " Naziv teme:".$this->getNazivTeme()." Naziv podteme:"
            .$this->nazivPodteme.".";
    }
	public function destroy(){
		$this->id=NULL;
		$this->brojPodteme=NULL;
		$this->nazivPodteme=NULL;
	}
}


/*
$podtema=new Podtema("Nogomet-vijesti");
$podtema->setKorisnik("Josip Bošnjak");
$podtema->setTema("Sport");
$podtema->ispis();
*/

?>

