<?php
namespace Classes;

use SplFileInfo;

class Header{
     const HTMLSTART="<!DOCTYPE html>";
    const HTMLLANG="<html lang=";
    const OPEN_HEAD="<head>";
    const CLOSE_HEAD="</head>";
    const META_CHARSET="<meta charset=";
    const ARROW_RIGHT=">";
    const VIEWPORT="<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">";
    const TITLE  = "<title>";
    const CLOSE_TITLE = "</title>";
    const SCRIPT_JS="<script src=";
    const CLOSE_JS_SCRIPT="></script>";
    const SCRIPT_CSS = " <link rel=\"stylesheet\" href=";

    public function __construct(private string $lan, private string $charset, private string $documentTitle, private string $curScript,
    private array $includes)
    {
        //default lan is en if not defined
        $this->lan=(empty($lan) || $lan=="")?"en":$lan;
        //if empty default charset is UTF-8
        $this->charset=(empty($charset) || $charset=="")?"UTF-8":$charset;
        //document title is empty string if there is nothing set
        $this->documentTitle=(empty($documentTitle) || $documentTitle=="")?"":$documentTitle;
        //if current script is empty basename will be activated
        $this->curScript=(empty($curScript) || $curScript=="")?basename("/",".php"):$curScript;
        //array of js and css includes empty array if there is no values defined or array size is 0
        $this->includes=(empty($includes) || $includes=="" || (int)count($includes)==0)?[]:$includes;
    }
    //this function will return generated html header
    public function generateHtmlHeader():void{
        echo self::HTMLSTART.self::HTMLLANG.$this->getHtmlLang().self::ARROW_RIGHT
        .self::OPEN_HEAD.self::META_CHARSET.$this->getCharset().self::ARROW_RIGHT.self::VIEWPORT.
        self::TITLE.self::getDocumentTitle().self::CLOSE_TITLE.self::printIncludeScript().self::CLOSE_HEAD;
    }
    private function getHtmlLang():string{
        return $this->lan;
    }
    private function getCharset():string{
        return $this->charset;
    }
    private function getDocumentTitle():string{
        return $this->documentTitle;
    }
    private function getCurrentScript():string{
        return $this->curScript;
    }
    //printing current environment
    public function printEnv():void{
        echo "Current script: ".self::getCurrentScript();
    }
    //public function to set include scripts
    public function setIncludeScripts(string|array $script):bool{
        $array=[];
        $added=false;
        if(gettype($script)!="array"){
            $array=explode(",",$script);
        }else{
            $array=$script;
        }
        foreach ($array as $value) {
            $this->includes[]=$value;
            $added=true;
        }
     
        return $added;
    }
    //functions to print include scripts
    private function printIncludeScript():string{
        $values="";
        $arrayCopy=$this->includes;
     
        $nv="";
        foreach ($arrayCopy as $value) {
            //get file info from string
          $info = new SplFileInfo($value);
          //get file extension
          $extension=$info->getExtension();
           if($extension=="js"){
              $nv=self::SCRIPT_JS.$value.self::CLOSE_JS_SCRIPT;
           }
           if($extension=="css"){
              $nv=self::SCRIPT_CSS.$value.self::ARROW_RIGHT;
           }
         
                $values.=$nv;
           
        }
        return $values;
        }
}