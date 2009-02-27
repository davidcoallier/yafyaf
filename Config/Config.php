<?php

class Yafyaf_Config
{
    const Database    = 'Database';
    const Modules     = 'Modules';
    const Templates   = 'Templates';
    const SiteConfigs = 'SiteConfigs';

    //const Links     = 'Links';
    //const Friends   = 'Friends';
    //const LinksToUs = 'LinksToUs';

    //const OtherSubmenu    = 'OtherSubmenu';
    //const AboutusSubmenu  = 'AboutUsSubmenu';
    
    private static $Instance;
    
    public static function GetInstance()
    {
        if (!isset(self::$Instance)) {
            self::$Instance = new stdClass();
            self::LoadConfigs();
        }
        
        return self::$Instance;
    }
    
    private static function LoadConfigs()
    {
        self::SetDatabaseConfigs();
        self::SetModulesConfigs();
        self::SetTemplatesConfigs();
        self::SetConfigs(self::SiteConfigs);
        //self::SetLinksConfigs();
        //self::SetFriendsConfigs();
        //self::SetLinksToUsConfigs();

        //self::SetSubmenus(self::OtherSubmenu);
        //self::SetSubmenus(self::AboutusSubmenu);
    }

    private static function setSubmenus($MenuName)
    {
        $here = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $OSubmenu  = simplexml_load_file($here . $MenuName . '.xml');
        
        // Modules
        $Subs = array();
        $i = 0;
        $Parent = str_ireplace('SubMenu', '', $MenuName);

        foreach ($OSubmenu as $Key => $SubMenu) {
            $Subs[$i] = new stdClass();
            $Subs[$i]->Name     = (string)$SubMenu->attributes()->Name;
            $Subs[$i]->DisplayName     = (string)$SubMenu->attributes()->DisplayName;
            $Subs[$i]->Url      = (string)$SubMenu->attributes()->Url;
            $Subs[$i]->Enabled  = (string)$SubMenu->attributes()->Enabled;
            $Subs[$i]->Parent   = $Parent;
            
            ++$i;
        }
        
        self::$Instance->$MenuName = $Subs;  
        self::$Instance->AllMenus->$MenuName = $Subs;      
    }

    private static function SetConfigs($name)
    {
        $here = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $Modules  = simplexml_load_file($here . $name . '.xml');
        
        // Modules
        $Mods = new stdClass();
        foreach ($Modules as $Key => $Module) {
            $Mods->$Key = (string)$Module;
        }

        self::$Instance->$name = $Mods;
    }
    
    private static function SetModulesConfigs()
    {
        $here = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $Modules  = simplexml_load_file($here . self::Modules . '.xml');
        
        // Modules
        $Mods = array();
        foreach ($Modules as $Key => $Module) {
            $Mods[] = $Module->attributes();
        }
        
        self::$Instance->Modules = $Mods;
    }
    
    private static function SetTemplatesConfigs()
    {
        $here = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $Templates = simplexml_load_file($here . self::Templates . '.xml');
        
        // Set the template
        foreach ($Templates as $Template) {
            if ($Template->attributes()->Active == 'true') {
                self::$Instance->Template = (string)$Template->attributes()->Name;
            }
        }
        
        if (!isset(self::$Instance->Template)) {
            self::$Instance->Template = $Templates->Default->attributes()->Name;
        }
    }
    
    private static function SetDatabaseConfigs()
    {
        $here = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $Database = simplexml_load_file($here . self::Database . '.xml.php');
        
        // Database
        self::$Instance->Database->Type     = (string)$Database->Type;
        self::$Instance->Database->Hostname = (string)$Database->HostName;
        self::$Instance->Database->Username = (string)$Database->UserName;
        self::$Instance->Database->Password = (string)$Database->PassWord;
    }
    
    private static function SetLinksConfigs()
    {
        $here = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $Links = simplexml_load_file($here . self::Links . '.xml');
        
        $NSLinks = array();
        foreach ($Links as $Link) {
            $NSLinks[(string)$Link->attributes()->Name] = (string)$Link->attributes()->URL;
        }
        
        self::$Instance->Links = $NSLinks;
    }
}
