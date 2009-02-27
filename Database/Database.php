<?php

class Yafyaf_Database
{
    public static $DbObject;
    
    public static function GetInstance()
    {
        $Type = Yafyaf_Config::GetInstance()->Database->Type;
        $ClassName = 'Yafyaf_Database_' . $Type;
        return new $ClassName;
    }
}