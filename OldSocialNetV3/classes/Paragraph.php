<?php
namespace Classes;
class Paragraph{
    const OPEN_P="<p>";
    const CLOSE_P="</p>";

    public function __construct(private string $pContent)
    {
        $this->pContent=$pContent;
    }
    public function returnPContent():string{
        return $this->pContent;
    }
    public function returnParagraph():string{
        $par="";
        $par.=self::OPEN_P.$this->returnPContent().self::CLOSE_P;
        return $par;
    }
}