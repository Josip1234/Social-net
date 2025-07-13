<?php
class Image
{
    private $alt;
    private $complete_img;
    private $source_img;

    const START_TAG = "<img src='";
    const MIDDLE_TAG = "' alt='";
    const CLOSE_TAG = "'>";
    const ROOT_URL = "/Social-net/";

    public function __construct($alt, $complete_img,$source_img)
    {
        $this->alt = $alt;
        $this->complete_img;
        $this->source_img=$source_img;
    }

public function getAlt() {return $this->alt;}

	public function getCompleteImg() {return $this->complete_img;}

	public function getSourceImg() {return $this->source_img;}

	public function setAlt( $alt) {$this->alt = $alt;}

	public function setSourceImg( $source_img) {$this->source_img = $source_img;}

	
    public function setCompleteImg()
    {
        $this->complete_img = Image::START_TAG.$this->getSourceImg().IMAGE::MIDDLE_TAG.$this->getAlt().Image::CLOSE_TAG;
    }

    //this function will convert urls from database to real images which will be printed on website
    public function convert_urls_to_images($array_of_urls){
       $imgs=array();
       foreach ($array_of_urls as $value) {
           $this->setSourceImg(Image::ROOT_URL.$value);
           $this->setAlt($value);
           $this->setCompleteImg();
           $imgs[]=$this->getCompleteImg();
       }
       return $imgs;
    }
}
