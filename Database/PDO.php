<?php

class Yafyaf_Database_PDO
{
    public $db;
    
    public function __construct()
    {
        $DbConfig = Yafyaf_Config::GetInstance()->Database;
        $this->db = new PDO($DbConfig->Hostname, $DbConfig->Username, $DbConfig->Password);
    }
    
    public function GetInstance()
    {
        return new Yafyaf_Database_PDO();
    }
}