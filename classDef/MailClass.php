<?php

//include '../db_access/common.php';        //error if incl
include './DBclass.php';
include './FamilyClass.php';


class MailClass 
{
    var $famObj;
    var $subject;
    var $text;
    
    function MailClass ($_famID)
    {
        $this->initFamObj($_famID);
        $this->subject  =   "FSW Elternstunden Erinnerungsmail";
        $this->setText();
    }
    
        
    function initFamObj ($_famID)
    {   
        $sql  = "SELECT * FROM " . T_FAM . " WHERE " . F_FAM_ID . "=" . $_famID . ";";   
        $dbRow      = DBclass::query($sql)->all(); 
        
        $this->famObj   =   new FamilyClass($dbRow[0]);
    }
    
    function setText ()
    {
        $this->text =   "Liebe Familie " . $this->famObj->getFamNam () . ",
            dies ist eine Erinnerungsmail der FSW. Ihr habt im aktuellen Schuljahr bereits " . /*$this->famObj->returnGeleisteteStunden () .*/ " Elternstunden
            geleistet. Insgesamt m&uuml;sst Ihr ";
        
        if ($this->famObj->isSingle ())
        {   $this->text .=  "" . PENSUM_SORGERECHT_ALLEIN . ""; }
        else
        {   $this->text .=  "" . PENSUM_SORGERECHT_GEMEINSAM . ""; }
        
        $this->text .= " Stunden absolvieren.
        Bitte denkt daran, dass nicht erf&uuml;lltes Pensum zum " . ABGABEDATUM . " in eine finanzielle Entsch&auml;digung 
            gegen&uuml;ber der FSW im Sinne der Schulgemeinschaft umgewandelt und berechnet wird.
            
            Ihr k&ouml;nnt Informationen zu den von Euch geleisteten Stunden unter diesem Link pflegen: " . USER_URL . $this->famObj->getCryptoSecret () . " .";

            //In diesem QR-Code ist Euer persönlicher Link kodiert. Druckt ihn Euch aus und hängt ihn Euch an den Kühlschrank, dann könnt Ihr ihn nicht vergessen:
            //Vorschau Ihres QR Code

        $this->text .=  "Viele Grü&uuml;&szlig;e, Euer Sekretariat der FSW";
    }
    
    function getText ()
    {   return $this->text; }
    
    function sendMail ()
    {   
        $header = array('From'  => 'sekretariat@fsw.de',
                'charset'       => 'iso-8859-1');
                //'Content-type'  => 'text/html',                
                //'Reply-To' => 'webmaster@example.com',
                //'X-Mailer' => 'PHP/' . phpversion()
                //);
        
        mail(
            $this->famObj->getFamMail(1) . "," . $this->famObj->getFamMail(2),
            $this->subject,
            $this->text,
            $header
            //array|string $additional_headers = [],
            //string $additional_params = ""
        );
    }
        
    
}
