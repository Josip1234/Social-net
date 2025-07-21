<?php
class Image
{
    private $alt;
    private $complete_img;
    private $source_img;
    private $image_class;

    const START_TAG = "<img src='";
    const MIDDLE_TAG = "' alt='";
    const CLOSE_TAG = ">";
    const ROOT_URL = "/Social-net/";
    const IMAGE_CLASS=" class='";
    const CLOSE_APOSTROPHE="'";

    public function __construct($alt,  $complete_img,  $source_img,  $image_class)
    {
        $this->alt = $alt;
        $this->complete_img = $complete_img;
        $this->source_img = $source_img;
        $this->image_class = $image_class;
    }
    public function getAlt()
    {
        return $this->alt;
    }

    public function getCompleteImg()
    {
        return $this->complete_img;
    }

    public function getSourceImg()
    {
        return $this->source_img;
    }

    public function getImageClass()
    {
        return $this->image_class;
    }

    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    public function setSourceImg($source_img)
    {
        $this->source_img = $source_img;
    }

    public function setImageClass($image_class)
    {
        $this->image_class = $image_class;
    }





    public function setCompleteImg()
    {
        $this->complete_img = Image::START_TAG . $this->getSourceImg() . Image::MIDDLE_TAG . $this->getAlt() .Image::CLOSE_APOSTROPHE .Image::IMAGE_CLASS.$this->getImageClass().Image::CLOSE_APOSTROPHE.Image::CLOSE_TAG;
    }

    //this function will convert urls from database to real images which will be printed on website
    public function convert_urls_to_images($array_of_urls)
    {
        $imgs = array();
        foreach ($array_of_urls as $value) {
            $this->setSourceImg(Image::ROOT_URL . $value);
            $this->setAlt($value);
            $this->setCompleteImg();
            $imgs[] = $this->getCompleteImg();
        }
        return $imgs;
    }

    //this function will print random image urls from our database 
    //alt wil be set to any random number
    //source img id is generated from 0 to max number of records in table 
    //there is posibility to get empty img 
    public function get_nth_number_of_random_images_from_database($how_many, $database_connection, $number_of_records_in_table)
    {
        $dat = array();
        $dat[] = Scanned_data::COLUMN_NAME;
        $number_of_records = $number_of_records_in_table[0];
        $image_array = array();
        $image_array = $database_connection->print_all_data_from_database(Scanned_data::TABLE_NAME, $dat);
        $img_array = array();
        //id between 0 and some size in some table
        //limit printing images by how many parameter
        for ($index = 0; $index < $how_many; $index++) {
            $random_id = rand(0, $number_of_records);
            $this->setSourceImg($image_array[$random_id]);
            $this->setAlt(rand());
            $this->setCompleteImg();
            $img_array[] = $this->getCompleteImg();
        }
        return array_filter($img_array);
    }
}
