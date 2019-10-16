<?php


class Controller extends DataBase
{
  private static $vars = [];

    static function CreateView($viewName, $data = []){

         foreach($data as $key => $val){
           self::$vars[$key] = $val;
         }
          extract(self::$vars);

        require_once("./Views/$viewName.php");
        
    }
}
