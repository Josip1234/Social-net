<?php 
namespace App\Helpers;
class Conversions{
    //convert assoc array into indexed array
    public static function convertToIndexArray(array $array){
        $indexArray=[];
        foreach ($array as $value) {
            foreach ($value as $value2) {
                $indexArray[]=$value2;
            }
        }
        return $indexArray;
    }
}