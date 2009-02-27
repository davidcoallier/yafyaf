<?php

class MainController
{
    public $Action;
    public $Module = 'Home';
    
    public function __construct()
    {
        $this->SetAction();
        $this->SetModule();
    }
    
    public function SetAction()
    {
        $this->Action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'Home';
    }
    
    public function SetModule()
    {
        $Modules = Yafyaf_Config::GetInstance()->Modules;
        
        if (in_array($this->Action, $Modules)) {
            $this->Module = $this->Action;
        }
    }
    
    public function ProcessOutput()
    {
        ob_start();
        
        $this->GetHtmlHeader();
        $this->GetHtmlMenus($this);
        $this->GetHtmlFooter();
        
        $Page = ob_get_contents();
        ob_end_clean();
        
        return $Page;
    }
    
    public function GetHtmlHeader()
    {
        include YAFYAF_MARKUP . 'header.html.php';
    }
    
    public function GetHtmlFooter()
    {
        include YAFYAF_MARKUP . 'footer.html.php';
    }

    public function GetHtmlMenus()
    {
        global $yafyaf;
        $yafyaf = $this;
        include YAFYAF_MARKUP . 'menus.html.php';
    }
    
    public function GetModule()
    {
        $Module = $this->Module;
        
        // Do this automatically with the Module.controller.php file.
        require_once YAFYAF_MODULES . $Module . '/Module.controller.php';
        $ClassName = 'Yafyaf_Module_' . $Module;
        $Class     = new $ClassName;
        $Class->Generate();
    }
}
