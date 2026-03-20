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
    //convert assoc array into one int value
    public static function convertToIntValue(array $array,string $valueOfIndex):int{
        $value=0;
        //if number of items exceedes 1 do not convert array or it has no values 
        if(count($array)===1){
            $value=$array[0][$valueOfIndex];
        }
        return $value;
    }
}