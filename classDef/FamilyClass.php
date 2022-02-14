<?php

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
        
        $this->calculateStundenFromDB();
        //$this->lastUserEdit         =   0;    //init mit 0 sorgt dafuer, dass im Admin-Ansicht die letzte Spalte leer bleibt
        //$this->geleisteteStunden    =   0;    //entfernt alle Einträge aus Tabelle weil per default alle gel Stunden auf 0 gesetzt werden
        
    }  
    
    function setGeleisteteStunden ($_h)
    {   $this->geleisteteStunden    =   $_h;    }
    
    function returnGeleisteteStunden ()
    {   return $this->geleisteteStunden;    }
       
    function getIsPensumErfuellt ()
    {
        $pensum =   0;
        
        //weise zu erledigendes Pensum entspr allein/gemeinsam Sorgerecht zu
        if ($this->isSingle() )
        {   $pensum =   PENSUM_SORGERECHT_ALLEIN;       }
        else
        {   $pensum =   PENSUM_SORGERECHT_GEMEINSAM;    }
                           
        return ( $pensum -   $this->returnGeleisteteStunden ()) ;
        
        /*if ( 0 >= $pensum )
        {   return 1;   }
        else
        {   return 0;   }*/
    }
    
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
    
    function calculateStundenFromDB ()
    {  
        //read Stunden pro Family from DB
        $_famEinsatzStunden = DBclass::query("SELECT * FROM " . T_EINSAETZE . " WHERE `FamID` = " . $this->getFamID() . " ORDER BY `TimeStamp` DESC;\"")->all();
        
        $lastUserEdit = 0; //erster Eintrag ist aus MySQL ORDER DESC-Statement auch gleichzeitig das aktuellste UserEdit
        foreach ($_famEinsatzStunden as $singleEinsatz)
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
