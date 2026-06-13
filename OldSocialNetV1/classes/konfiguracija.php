<?php
include "../functions.php";
class Forum{
    private string $korisnik;
    public function setKorisnik(string $korisnik){
        $this->korisnik=$korisnik;
    }
    public function getKorisnik(){
        return $this->korisnik;
    }
}
class Tema{
    public int $id;
    public string $nazivKorisnika;
    public string $brojTeme;
    public string $nazivTeme;

    public function __construct(int $brojTeme=0,string $nazivKorisnika, string $nazivTeme)
    {
        $this->id=rand();
        $this->nazivKorisnika=$nazivKorisnika;
        $this->brojTeme=rand();
        $this->nazivTeme=$nazivTeme;
    }
    public function ispis(){
        echo $this->id."\n";
        echo $this->nazivKorisnika."\n";
        echo $this->brojTeme."\n";
        echo $this->nazivTeme."\n";

    }

      public function setKorisnik(string $korisnik){
        $this->nazivKorisnika=$korisnik;
    }

    public function getKorisnik(){
        return $this->nazivKorisnika;
    }
    public function ispisTrenutneTeme(){
        echo "Korisnik: ".$this->getKorisnik()." Naziv teme: ".$this->getNazivTeme().".";
    }
    public function setTema(string $nazivTeme){
        $this->nazivTeme=$nazivTeme;
    }
    public function getId(){
        return $this->id;
    }
    public function getBrojTeme(){
        return $this->brojTeme;
    }
    public function getNazivTeme(){
        return $this->nazivTeme;
    }
  

}
class Podtema extends Tema{
    public int $id;
    private string $brojPodteme;
    private string $nazivPodteme;


    
    public function __construct(string $nazivPodteme)
    {
        $this->id=rand();
        $this->brojPodteme=rand();
        $this->nazivPodteme=$nazivPodteme;
    }
        public function ispis(){
         
        echo $this->id."\n";
        echo $this->brojPodteme."\n";
        echo $this->nazivPodteme."\n";
        echo " Naziv podteme:".$this->nazivPodteme.".";

    }

}
/*
$tema=new Tema(0,"Josip","MojaTema");
$tema->setKorisnik("Josip Bošnjak");
$podtema=new Podtema("Blabla");
$tema->ispis();
$podtema->ispis();
echo "<br>";
$podtema=new Podtema("Nogomet - vijesti");
$tema->setTema("Sport");
$podtema->ispis();
*/
$tema = new Tema(0,"Josip Bošnjak","Sport");
$podtema=new Podtema("Nogomet - vijesti");
$podtema->ispis(); 
