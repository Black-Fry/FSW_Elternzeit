<?php

include_once '../db_access/common.php';
include_once './FamilyClass.php';
include_once './DBclass.php';


class MailClass 
{
    public $famObj;
    
    public function MailClass ($_famID)
    {
        $this->initFamObj($_famID);
    }
    
    public function initFamObj ($_famID)
    {   
        $sql            = "SELECT * FROM " . T_FAM . " WHERE " . F_FAM_ID . "=" . $_famID . ";\"";
        $this->famObj   = DBclass::query($sql)->all();    
    }
    
    public function sendMail ()
    {   }
        
    
}
