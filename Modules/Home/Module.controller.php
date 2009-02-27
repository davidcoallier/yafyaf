<?php

class Yafyaf_Module_Home extends Yafyaf_Module_Abstract
{
    const NAME = 'Home';
    
    public function Generate()
    {
        include YAFYAF_MODULES . self::NAME . '/Module.html.php';
    }
}
