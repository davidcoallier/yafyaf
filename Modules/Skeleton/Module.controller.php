<?php

class Yafyaf_Module_Skeleton extends Yafyaf_Module_Abstract
{
    const NAME = 'Skeleton';
    
    public function Generate()
    {
        include YAFYAF_MODULES . self::NAME . '/Module.html.php';
    }
}