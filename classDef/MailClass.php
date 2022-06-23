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
        $link = USER_URL . $this->famObj->getCryptoSecret ();
        
        $this->text =   "Liebe Familie " . $this->famObj->getFamNam () . ",<br><br>
            dies ist eine Erinnerungsmail der FSW.<br><br>Toll - Ihr habt im aktuellen Schuljahr bereits einige " . /*$this->famObj->returnGeleisteteStunden () .*/ " Elternstunden
            geleistet. Danke f&uuml;r Euer Engagement!<br>
            Insgesamt m&uuml;sst Ihr ";
        
        /* INITIAL - hier sind die Stati noch unbekannt in der DB  */
        $this->text .= " 20 (alleinerziehend) bzw. 40 ";
        
        /*if ($this->famObj->isSingle ())
        {   $this->text .=  "" . PENSUM_SORGERECHT_ALLEIN . ""; }
        else
        {   $this->text .=  "" . PENSUM_SORGERECHT_GEMEINSAM . ""; }*/
        
        $this->text .= " Stunden absolvieren.<br>
        Bitte denkt daran, dass nicht erf&uuml;lltes Pensum zum " . ABGABEDATUM . " in eine finanzielle Entsch&auml;digung<br>
            gegen&uuml;ber der FSW im Sinne der Schulgemeinschaft umgewandelt und berechnet wird.<br><br>";
        
        $this->text .= "Um die von Euch geleistete Arbeit geeignet zu dokumentieren, haben wir zuletzt mit Papierformularen gearbeitet.<br>
        Wir m&ouml;chten mit Euch gemeinsam den n&auml;chsten Schritt in Richtung Digitalisierung gehen und haben deshalb eine Web-Oberfl&auml;che erarbeitet.<br>
            Jede Familie erh&auml;lt eine personalisierte Ansicht. Eure Ansicht ist gegen den unbefugten Zugriff durch Dritte abgesichert.<br><br>";        

        $this->text .=  "In dem folgenden QR-Code (falls er nicht angezeigt wird, klickt im Mail-Programm auf 'Bilder herunterladen') ist Euer pers&ouml;nlicher, geheimer Link kodiert.<br>
            Druckt ihn Euch aus und h&auml;ngt ihn Euch an den K&uuml;hlschrank, dann k&ouml;nnt Ihr ihn nicht vergessen:<br>";
        
        $this->text .=  '<img src="' . GENERATE_QR . $link . '" />';
        
        $this->text .=  "<br>Sollte der QR-Code nicht angezeigt werden, k&ouml;nnt Ihr die Informationen zu den von Euch geleisteten Stunden ebenfalls unter diesem Link pflegen: <a href=" . $link . ">" . $link . "</a> .<br>";
        
        $this->text .=  "<br>Viele Gr&uuml;&szlig;e,<br> Euer Sekretariat der FSW";
    }
    
    function getText ()
    {   return $this->text; }
    
    function sendMail ()
    {   
        $header = array('From'  => 'sekretariat@freie-schule-woltersdorf.de',
                'charset'       => 'iso-8859-1',
                'Content-type'  => 'text/html');
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
