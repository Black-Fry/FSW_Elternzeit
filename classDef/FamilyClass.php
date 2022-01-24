<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of FamilyClass
 *
 * @author Micha
 */
class FamilyClass 
{
    var $FamID;
    var $FamNam;
    var $CryptURL;
    var $Single;
    var $FamMailOne;
    var $FamMailTwo;
    var $lastUserEdit;
    var $geleisteteStunden;
    
    function FamilyClass ($_dbRow)
    {	   
        //print_r($_dbRow);
        if ($_dbRow[FamID])
        {   $this->FamID        =   $_dbRow[FamID]; }
        else
        {   $this->FamID        =   ""; }

        if ($_dbRow[FamNam])
        {   $this->FamNam        =   $_dbRow[FamNam]; }
        else
        {   $this->FamNam        =   ""; }        
        
        if ($_dbRow[CryptURL])
        {   $this->CryptURL      =   $_dbRow[CryptURL]; }
        else
        {   $this->CryptURL      =   ""; }
        
        if ($_dbRow[Single])
        {   $this->Single        =   $_dbRow[Single]; }
        else
        {   $this->Single        =   FALSE; }
        
        if ($_dbRow[FamMailOne])
        {   $this->FamMailOne    =   $_dbRow[FamMailOne]; }
        else
        {   $this->FamMailOne    =   ""; }

        if ($_dbRow[FamMailTwo])
        {   $this->FamMailTwo    =   $_dbRow[FamMailTwo]; }
        else
        {   $this->FamMailTwo    =   ""; }        
        
        $this->geleisteteStunden    =   0;
        $this->lastUserEdit         =   0;
        
    }  
    
    function setGeleisteteStunden ($_h)
    {   $this->geleisteteStunden    =   $_h;    }
    
    function returnGeleisteteStunden ()
    {   return $this->geleisteteStunden;    }
        
    function getFamID ()
    {   return $this->FamID;    }
    
    function getFamNam ()
    {   return $this->FamNam;    }
    
    function getCryptoSecret ()
    {   return $this->CryptURL;    }
    
    function getFamMail ($_oneOrTwo)
    {   
        switch ($_oneOrTwo)
        {
            case 1:
                return $this->FamMailOne;
        
            case 2:
                return $this->FamMailTwo;
        }       
    }
    
    function isSingle ()
    {
        if ($this->Single)  {   return TRUE;    }
        
        return FALSE;
    }
    
    function calculateStundenFromDB ($_famEinsaetzStunden)
    {  
        $lastUserEdit = 0; //erster Eintrag ist aus MySQL ORDER DESC-Statement auch gleichzeitig das aktuellste UserEdit
        foreach ($_famEinsaetzStunden as $singleEinsatz)
        {   
            if (0 == $lastUserEdit)
            {
                $this->lastUserEdit =   $singleEinsatz[TimeStamp];
                $lastUserEdit       =   1;
            }
            //echo $singleEinsatz[EinsatzLength] . " ";
            $this->geleisteteStunden    +=   $singleEinsatz[EinsatzLength];    
        }
        
    }
    
    function setLastUserEdit ($_ts)
    {   $this->lastUserEdit  =   $_ts;   }
    
    function getLastUserEdit ()
    {   
        if ($this->lastUserEdit)  {   return $this->lastUserEdit;       }
        
        return "-";        
    }
    
}
