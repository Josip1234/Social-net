<?php
class Tema{
    private $id;
    private $nazivKorisnika;
    private $brojTeme;
    private $nazivTeme;

    public function __construct(string $nazivKorisnika, string $nazivTeme)
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


}
$tema = new Tema("Josip","Moja tema");
$tema->ispis();