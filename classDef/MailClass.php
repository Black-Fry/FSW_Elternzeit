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
        Bitte denkt daran, dass nicht erf&uuml;lltes Pensum zum Ende des Schuljahres in eine finanzielle Entsch&auml;digung<br>
            gegen&uuml;ber der FSW im Sinne der Schulgemeinschaft umgewandelt und berechnet wird.<br><br>";
        
        $this->text .= "Um die von Euch geleistete Arbeit geeignet zu dokumentieren, haben wir vor einiger Zeit mit Papierformularen gearbeitet.<br>
        Seit dem vergangenen Schuljahr m&ouml;chten mit Euch gemeinsam den n&auml;chsten Schritt in Richtung Digitalisierung gehen und haben deshalb eine Web-Oberfl&auml;che erarbeitet.<br>
            Jede Familie erh&auml;lt eine personalisierte Ansicht. Eure Ansicht ist gegen den unbefugten Zugriff durch Dritte abgesichert.<br><br>";        

        $this->text .=  "In dem folgenden QR-Code (falls er nicht angezeigt wird, klickt im Mail-Programm auf 'Bilder herunterladen') ist Euer pers&ouml;nlicher, geheimer Link kodiert.<br>
            Druckt ihn Euch aus und h&auml;ngt ihn Euch an den K&uuml;hlschrank, dann k&ouml;nnt Ihr ihn nicht vergessen:<br>";
        
        $this->text .=  '<img src="' . GENERATE_QR . $link . '" />';
        
        $this->text .=  "<br>Sollte der QR-Code nicht angezeigt werden, k&ouml;nnt Ihr die Informationen zu den von Euch geleisteten Stunden ebenfalls unter diesem Link pflegen: <a href=" . $link . ">" . $link . "</a> .<br>";
        
        $this->text .=  "<br>Viele Gr&uuml;&szlig;e,<br> Euer Sekretariat der FSW";
    }
 
//    function setText ()
//    {
//        $link = USER_URL . $this->famObj->getCryptoSecret ();
//        
//        $this->text =   "Hallo liebe Familie " . $this->famObj->getFamNam () . ",<br><br>
//            
//        In den vergangenen Monaten habt Ihr mit gro&szlig;er Sorgfalt Eure geleisteten Elternstunden &uuml;ber das <br>
//        neue Portal gepflegt. Damit habt Ihr uns super unterst&uuml;tzt, denn ein sehr gro&szlig;er Berg manueller <br>
//        Arbeit (Zettel einsammeln & nachhaken, manueller &Uuml;bertrag ins System, Auswerten etc.) ist uns <br>
//        dadurch erspart geblieben - Danke!<br><br>
//        Nun l&auml;uft das aktuelle Schuljahr schon seit einiger Zeit und viele von Euch sind schon wieder sehr <br>
//        emsig und unterst&uuml;tzen die Schulgemeinschaft durch diverse Elternstunden. Nat&uuml;rlich m&ouml;chten wir <br>
//        das Portal vom letzten Jahr auch in diesem Jahr wieder verwenden. <br><br>
//        Dazu braucht es allerdings einen Tabula Rasa- Durchgang. <b>Wir werden alle Eure Eingaben l&ouml;schen</b> <br>
//        und mit einem 'neuen Gewissen' starten. Warum? Ganz einfach deshalb, weil wir verantwortlich mit <br>
//        Euren Daten umgehen und nichts speichern wollen, was nicht ben&ouml;tigt wird.<br><br>
//        Ihr sollt aber die Chance bekommen, Eure Eingaben aus dem vergangenen Schuljahr zu speichern. <br>
//        Damit Ihr das tun k&ouml;nnt, &ouml;ffnet doch einmal Eure pers&ouml;nliche Portalseite &uuml;ber den QR-Code:<br>";
//        
//        $this->text .=  '<img src="' . GENERATE_QR . $link . '" />';
//
//        $this->text .= '<br>oder Euren pers&ouml;nlichen Link: <a href=' . $link . '>' . $link . '</a> .<br>';
//
//        $this->text .= 'Wir haben dort eine <b>Export-Funktion</b> eingearbeitet, mit der Ihr Euren gesamten Datensatz ins<br>
//            Tabellenkalkulations-Werkzeug Eurer Wahl &uuml;bertragen k&ouml;nnt. Ihr solltet direkt &uuml;ber der Tabelle<br>
//            diese, hier rot umrandete, Schaltfl&auml;che sehen:<br>';
//        
//        $this->text .=  '<img src="http://fsw.ossoelmi.berlin/img/screenshot_export.png"></img><br>';
//        
//        $this->text .= "Ihr habt nun <b>ab dem kommenden Mittwoch (16. November 2022) einige Tage Zeit, um Eure Eingaben<br>
//            zu exportieren</b>. Am <b>Sonntag, dem 27. November</b> werden wir das Portal f&uuml;r wenige Minuten vom <br>
//            Netz nehmen, <b>alle dort gespeicherten Daten l&ouml;schen</b> und das Ganze neu aufsetzen. Anschlie&szlig;end<br>
//            erhaltet Ihr wieder eine Einladungsmail samt pers&ouml;nlichem Zugang zu Eurer pers&ouml;nlichen<br>
//            Portalseite, auf der Ihr Eure Elternstunden im aktuellen Schuljahr pflegen k&ouml;nnt. <br><br>
//            <u>Bitte beachten:</u> <b>nach dem 27. November wird Euer pers&ouml;nlicher Zugang neu generiert. QR-Codes<br>
//            und Links aus dem vorhergehenden Schuljahr werden dann nicht mehr funktionieren.</b><br><br>
//            Noch Fragen?<br><br>
//            Viele Gr&uuml;&szlig;e,<br>
//            Euer Sekretariat & der AK IT";
//    }

    
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
