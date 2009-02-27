<?php

abstract class Yafyaf_Module_Abstract
{
    abstract public function Generate();
    
    public static function GetInstance()
    {
        return new self;
    }
}