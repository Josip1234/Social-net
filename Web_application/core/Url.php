<?php 
namespace Core;
class Url{
    public static function base():string{
        //	The scheme part of the request's URI
        $scheme=$_SERVER['REQUEST_SCHEME']??'http';
        // $_SERVER['HTTP_HOST'] is: Contents of the Host: header from the current request, 
        $host=$_SERVER['HTTP_HOST'];
        //this removes everything from /public
        //strtok Tokenize string Note that only the first call to strtok uses the string argument.
        // @param string $string The string being split up into smaller strings (tokens).
        //param string|null $token The delimiter used when splitting up str.
        //$_SERVER['REQUEST_URI'] will hold the full request path including the querystring.
         $path=strtok($_SERVER['REQUEST_URI'],'?');
         //Perform a regular expression search and replace
         //@param string|string[] $pattern
        //The pattern to search for. It can be either a string or an array with strings.
        //Several PCRE modifiers are also available, including the deprecated 'e' (PREG_REPLACE_EVAL), which is specific to this function.
        //@param string|string[] $replacement
        //The string or an array with strings to replace. 
        //@param string|string[] $subject
        //The string or an array with strings to search and replace.
        //If subject is an array, then the search and replace is performed on every entry of subject, and the return value is an array as well.
         $path=preg_replace('#/public/.*$#','/public',$path);
         return $scheme.'://'.$host.$path;
    }
}