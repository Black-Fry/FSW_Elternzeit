<?php

include_once './DBclass.php';

/**
 * Description of EinsatzClass
 *
 * @author Micha
 */
class EinsatzClass 
{
    var $einsatzID;     //hochzaehlender Index
    var $zweckID;       //eindeutige ID fuer Zweckname
    var $zweckNam;
    var $date;
    var $length;
    var $editDate;      //timestamp
    var $comment;
    
    function EinsatzClass ($_dbRow)
    {	   
        //print_r($_dbRow);
        if ($_dbRow[E_EINSATZ_ID])
        {   $this->einsatzID    =   $_dbRow[E_EINSATZ_ID]; }
        else
        {   $this->einsatzID    =   ""; }

        if ($_dbRow[E_EINSATZ_ZWECK_ID])
        {   $this->einsatzID    =   $_dbRow[E_EINSATZ_ID]; }
        else
        {   $this->einsatzID    =   ""; }   
        
        //$this->getZweckNam();
        
        if ($_dbRow[E_EINSATZ_EINSATZ_DATE])
        {   $this->date         =   $_dbRow[E_EINSATZ_EINSATZ_DATE]; }
        else
        {   $this->date         =   ""; }        
        
        if ($_dbRow[E_EINSATZ_LENGTH])
        {   $this->length       =   $_dbRow[E_EINSATZ_LENGTH]; }
        else
        {   $this->length       =   ""; }  
  
        if ($_dbRow[E_EINSATZ_TIME_STAMP])
        {   $this->editDate     =   $_dbRow[E_EINSATZ_TIME_STAMP]; }
        else
        {   $this->editDate     =   ""; }  
       
        if ($_dbRow[E_EINSATZ_COMMENT])
        {   $this->comment      =   $_dbRow[E_EINSATZ_COMMENT]; }
        else
        {   $this->comment      =   ""; }         
        
        //echo ($this->einsatzID . "," . $this->zweckID . ", " . $this->zweckNam . ", " . $this->length . ", " . $this->editDate . ", " . $this->comment);        
   
    }
    
    function getZweckNam ()
    {
        $sql    =   "SELECT " . Z_ZWECK_NAME . " FROM " . T_EINSATZ_ZWECKE . " WHERE " . Z_ZWECK_ID . " = " . $this->zweckID . ";\"";
        $result = DBclass::query($sql)->all();
        $this->zweckNam =   $result[Z_ZWECK_NAME];
    }
    
    function getEinsatzDate()
    {   return $this->date; }
    
    function getLength()
    {   return $this->length;   }
    
    function getEinsatzID()
    {   return $this->einsatzID;    }
    
    function getKommentar()
    {   return $this->comment;  }
    
}
