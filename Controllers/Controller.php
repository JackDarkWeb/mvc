<?php


class Controller extends DataBase
{
    static function CreateView($viewName, $data = []){

        require_once("./Views/$viewName.php");
        static::doSomeThing();
    }
}