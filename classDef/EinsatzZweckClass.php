<?php

include_once './DBclass.php';

/**
 * Description of EinsatzZweckeClass
 *
 * @author Micha
 */
class EinsatzZweckClass 
{
    public $zweckID;
    public $zweckNam;
    
    function EinsatzZweckClass ($_id)
    {
        $this->zweckID  =$_id;
        $this->resolveZweckNam();
    }
    
    function resolveZweckNam ()
    {
        $sql    =   "SELECT " . Z_ZWECK_NAME . " FROM " . T_EINSATZ_ZWECKE . " WHERE " . Z_ZWECK_ID . "=" . $this->zweckID . ";";
        $retVal = DBclass::query($sql)->all();
        $this->zweckNam = $retVal[Z_ZWECK_NAME];  
    }
    
    function getZweckID()
    {   return $this->zweckID;  }
    
    function getZweckNam ()
    {   return $this->zweckNam; }
}
