<?php
namespace Classes;
class Links{
  //made a mistake values are php scripts, php scripts var represents names of urls
  //need to fix this in the future versions of application
    public function __construct(private array $value,private array $phpScripts, private string $target)
    {
        $this->value=(count($value)==0)?[]:$value;
        $this->phpScripts=(count($phpScripts)==0)?[]:$phpScripts;
        $this->target=(empty($target) || $target=="")?"_self":$target;
        
    }

    public function returnUrls():array{
        $urls=array();
        $stringUrl="";
        foreach ($this->value as $key => $val) {
            $stringUrl.="<a href=\"".$val."\" target=\"".$this->target."\">";
            foreach ($this->phpScripts as $key2 => $value2) {
                $stringUrl.=$value2;
                unset($this->phpScripts[$key2]);
                break;
            }
            $stringUrl.="</a>";
            $urls[]=$stringUrl;
            $stringUrl="";
        }
        
        return $urls;
    }

}