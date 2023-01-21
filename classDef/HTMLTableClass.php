<?php

include_once 'classDef/FamilyClass.php';
include_once 'classDef/EinsatzZweckClass.php';
include_once 'classDef/DBclass.php';


/**
 * Description of FamClass
 *
 * @author Micha
 */
abstract class HTMLTableClass 
{
    public $view;      //user or admin
    public $htmlString;

    function __construct ()
    {	   }   
    
    public function echoWhoAmI ()
    {   echo ("HTMLTableClass ()"); }

    abstract protected function initTable ();
    
    abstract protected function createHeader ();
    
    /* adds row to existing table
     *  param _view: decides whether user or admin table shall be created & populated
     *  param _valueObj is either of FamilyClass (admin-View) or EinsatzClass (user-View)
     */
    abstract protected function addRow ($_valueObj);

    abstract protected function addFinalRow ();    

    abstract protected function finishTable ();
    
    abstract protected function returnHTML ();
    
}

class HTMLAdminTableClass extends HTMLTableClass
{

    public function __construct ()
    {   
//        echo ("HTMLAdminTableClass ()");
        $this->view    =   ADMIN_VIEW; 
        $this->initTable();
    }
    
    public function initTable ()
    {
        $this->htmlString   =   '<table id="adminTable" width="90%" class="sortierbar dezimalpunkt">';
        
        $this->createHeader();
    }
    
    public function createHeader ()
    {
        $this->htmlString   .=  '<thead>'
                            .       '<tr class="header">';     

        $this->htmlString   .=  
            '   <th><input type="checkbox" id="tickAll" name="tickAll" onclick = tickCheckBoxes() ></th>
                <!--<div class="col col-1">ID Familie</div>//-->
                <th class="sortierbar">Name</th>
                <!--<div class="col col-3">CryptoId</div>//-->
                <th>Alleinerziehend</th>
                <th>E-Mail 1</th>
                <th>E-Mail 2</th>
                <th>bisher geleistete Stunden</th>
                <th class="sortierbar dezimalpunkt">Pensum erfüllt</th>
                <th>letzte Eingabe</th>';

        $this->htmlString   .=      "</tr>"
                            .   "</thead>"
                            .   "<tbody>";
    }
    
    public function addRow ($_valueObj)
    {
        $pensum;
        $jsID = $_valueObj->getFamID();
//        error_log("id: ".$jsID);
//        echo $jsID;
        $this->htmlString   .=     '<tr>';
       
        /*
         * zusammengesetzte id (name, jsid, geleistete stunden) hilft beim callBgQueries() um Zeilen zu entscheiden 
         *  welche Zeilen gelöscht werden dürfen auf Buton-Druck (nur wenn gelStunden != 0)
         */
        $this->htmlString   .=  '<td>'
                            .   '   <input type="checkbox" id="check_' . $jsID . '_' . $_valueObj->returnGeleisteteStunden() .' " name="check_' . $jsID . '" >'
                            .   '</td>';
        //<div class="col col-1" data-label="ID_Fam">1</div>
        $this->htmlString   .=  '<td>'
                            .   '   <input type="text" id="FamNamID_' . $jsID . '" name="FamNamID_' . $jsID . '" size="10" value="' . $_valueObj->getFamNam() . '" onchange="bgQuery(\'' . "UPDATE" . '\', ' . ENCODED_T_FAM . ', \'' . F_FAM_NAM . '\', this, ' . $jsID . ')">'
                            .   '</td>';
        //<div class="col col-3" data-label="CryptoID">j7gdMH95hu7CZLss</div>
        $this->htmlString   .=  '<td align="center">'
                            .       '<label class="switch">
                                        <input type="checkbox" id="single_' . $jsID . ' name="single_' . $jsID;
        //aktiviere Checkbox, wenn FamObj == alleinerziehend
        if ($_valueObj->isSingle() )
        {   $this->htmlString .=  ' checked'; }
        $this->htmlString   .=  ' disabled><span class="slider"></span>'
                            .   '</label></td>';

        $this->htmlString   .=  '<td>'
                            .   '   <input type="text" id="FamMailOne_' . $jsID . '" name="FamMailOne_' . $jsID . '" size="15" value="' . $_valueObj->getFamMail(1) . '" onchange="bgQuery(\'' . "UPDATE" . '\', ' . ENCODED_T_FAM . ', \'' . F_FAM_MAIL_ONE . '\', this, ' . $jsID . ')">'
                            .   '</td>';
        $this->htmlString   .=  '<td>'
                            .   '   <input type="text" id="FamMailTwo_' . $jsID . '" name="FamMailTwo_' . $jsID . '" size="15" value="' . $_valueObj->getFamMail(2) . '" onchange="bgQuery(\'' . "UPDATE" . '\', ' . ENCODED_T_FAM . ', \'' . F_FAM_MAIL_TWO . '\', this, ' . $jsID . ')">'
                            .   '</td>';
        $this->htmlString   .=  '<td>'
                            //.   '<p align="center" id="geleisteteStunden_' . $jsID . '" name="geleisteteStunden_' . $jsID . '">' . $_valueObj->returnGeleisteteStunden () . '</p>'
                            .   '   <a href="' . ROOT_URL . '/views/user.php?cryurl=' . $_valueObj->getCryptoSecret() . '" target="_blank">' . $_valueObj->returnGeleisteteStunden () . '</a>'
                            .   '</td>';

        $this->htmlString   .=   '<td ';

            $pensumErfuellt =   $_valueObj->getIsPensumErfuellt ();

            //sind noch h abzusolvieren? (bg = rot, #ff9966)! Sonst bg = gruen, #D6EEEE
            if ( 0 < $pensumErfuellt )
            {   
                $this->htmlString   .=   'bgcolor="#ff9966"';   
            }            
            else
            {   $this->htmlString     .=   'bgcolor="#D6EEEE"';  }

            $this->htmlString     .=      '><p hidden>' . $pensumErfuellt . '</p>'
                            .   '</td>';

        $this->htmlString   .=  '<td>'
                            .   '   <p>' . $_valueObj->getLastUserEdit() . '</p>'
                            .   '</td>';
        
        //hidden td um js-Suchalgorithmus �ber Name & MailAdressen zu nutzen
        $this->htmlString   .=  '<td style="display:none;">' . $_valueObj->getFamNam() . ' ' . $_valueObj->getFamMail(1) . ' ' . $_valueObj->getFamMail(2) . '</td>';

        $this->htmlString   .=      '</tr>';

    }
    
    public function addFinalRow ()
    {      
        $this->htmlString   .=  '</tbody>'
            .   '<tfoot>'
            .       '<tr>'
            .           '<td></td>'
            .           '<td></td>'
            .           '<td></td>'
            .           '<td align="center">'
            .               '<input type="button" onClick="bgQuery(\'' . "DELETE" . '\', ' . ENCODED_T_FAM . ', 0, 0, 0)" value="Markierte Zeilen löschen"/>'
            .           '</td>'
            .           '<td align="center">'
            .               '<input type="button" onClick="bgQuery(\'' . "INSERT" . '\', ' . ENCODED_T_FAM . ', 0, 0, 0)" value="Eine neue Zeile einfügen"/>'
            .           '</td>'
            .           '<td align="center">'
            //.               '<input type="button" onclick=" window.open(\'../mockup/MailTemplate.htm\',\'_blank\')" value="Erinnerungsmail an alle markierten senden"/>'
            .              '<input type="button" onclick="prepareMails()" value="Erinnerungsmail an alle markierten senden"/>'
            .           '</td>'
            .           '<td></td>'
            .           '<td></td>'
            .       '</tr>'
            .   '</tfoot>';
    }
    
    public function finishTable ()
    {
        $this->htmlString   .=  '</table>';
    }
    
    public function returnHTML ()
    {
//        debug_to_console($this->htmlString);
        $this->finishTable();
        return $this->htmlString;   
    }
}


class HTMLUserTableClass extends HTMLTableClass
{
    public $myFamily;

    public function __construct ($_myFamily)
    {   
        $this->myFamily =   $_myFamily;   
        $this->view     =   USER_VIEW;
        $this->initTable();
    }
    
    public function initTable ()
    {
        $this->htmlString   =   "";
        $this->htmlString   .=   '<ul class="responsive-table">';
        
        $this->createHeader();
        
        $this->htmlString   .=  
                '</li>';
    }
    
    public function createHeader ()
    {
        $this->htmlString   .=  '<li class="table-header">'
            .   '   <!--<div class="col col-1">Nummer<br><br>(<b>noch statisch</b>)</div>//-->
                    <div class="col col-2">Datum</div>
                    <div class="col col-3">Stunden</div>
                    <div class="col col-4">Verabredete T&auml;tigkeit</div>
                    <div class="col col-5">Im Auftrag bzw. Rahmen der Arbeitsgruppe</div>';
    }
    
    //param wird benoetugt fuer einsatzobjekte
    public function addRow ($_valueObj)
    {
        $einsatzID  =  $_valueObj->getEinsatzID(); 
        
        $this->htmlString   .=     '<li class="table-row">';
        
        $this->htmlString   .=
            '<!--<div class="col col-1" data-label="Nummer"></div>//-->
             <div class="col col-2" data-label="Datum_"' . $einsatzID . '>
                <input type="date" name="datepicker_' . $einsatzID . '" id="datepicker_' . $einsatzID . '" value="' . $_valueObj->getEinsatzDate() . '" onchange="bgQuery(\'' . "UPDATE" . '\', ' . ENCODED_T_EINSAETZE . ', \'' . E_EINSATZ_EINSATZ_DATE . '\', this, ' . $einsatzID . ')">                
            </div>';
            
        $this->htmlString   .=  '<div class="col col-3" data-label="Stunden' . $einsatzID . '">';
        
        $this->htmlString   .= $this->generateDropDown(range(0, 21, 0.5), (E_EINSATZ_LENGTH . "_"), $einsatzID, $_valueObj->getLength(), E_EINSATZ_LENGTH);

        $this->htmlString   .=    '</div>';
        
        $this->htmlString   .=
             '<div class="col col-4" data-label="Action">'
                . '<textarea id="einsatzText_' . $einsatzID . '" name="einsatzText_' . $einsatzID . '" cols="35" rows="3" onchange="bgQuery(\'' . "UPDATE" . '\', ' . ENCODED_T_EINSAETZE . ', \'' . E_EINSATZ_COMMENT . '\', this, ' . $einsatzID . ')">' . $_valueObj->getKommentar() . '</textarea></div>';

        $this->htmlString   .=
            '<div class="col col-5" data-label="AG_' . $einsatzID . '">';
         
            $einsatzZwecke      =   $this->readAllZweckeFromDB();
            //echo $_valueObj->returnZweckNam();
            $this->htmlString   .= $this->generateDropDown($einsatzZwecke, "zweck_", $einsatzID, $_valueObj->returnZweckNam(), E_EINSATZ_ZWECK_ID);
        
        $this->htmlString   .=     '</div>';
        
        $this->htmlString   .=      '</li>';
    }
    

    public function generateDropDown ($_array, $_selectNam, $_einsID, $_selectedValue, $_updateFieldNam)
    {        
        $html   =   '<select id="' . $_selectNam . $_einsID . '" name="' . $_selectNam . $_einsID . '"';
        $html   .=  ' onchange="bgQuery(\'' . "UPDATE" . '\', ' . ENCODED_T_EINSAETZE . ', \'' . $_updateFieldNam . '\', this, ' . $_einsID . ')"';
        $html   .=  '>';
        //print_r($_array);
        $i = 0;
        foreach ($_array as $element)
        {   
            $html   .= '<option id="' . $i . '" value="' . $element . '"';
            
            if ($_selectedValue ==  $element)
            {   $html   .=  ' selected';    }
            
            $html   .=  '>' . $element . '</option>' ;          
            
            $i++;
        }
        
        $html   .=  '</select>';       
            
        return $html;
    }
    
    public function readAllZweckeFromDB ()
    {
        $sql    =   "SELECT * FROM " . T_EINSATZ_ZWECKE . ";";
        //echo $sql;
        $zwecke =   DBclass::query($sql)->all();
        //print_r($zwecke);
        
        //Index ist nun der Spatlenname
        //rearrange aray, um index 0...X zu erhalten - damit es zur Funktion $this->generateDropDown() passt
        $zwecke_rearranged = array();
        foreach ($zwecke as $zweck)
        {   array_push($zwecke_rearranged, $zweck[Z_ZWECK_NAME]);   }
        
        return $zwecke_rearranged;
    }
    
    public function addFinalRow ()
    {      
        $this->htmlString   .=  
            '   <li class="table-header">
                <!--<div class="col col-1"></div>//-->
                <div class="col col-2">Summe Stunden absolviert: </div>
                <div class="col col-3">
                    <div style="display:inline" id="summe_stunden">' . $this->myFamily->returnGeleisteteStunden() . '</div>
                    h / 
                    <div style="display:inline" id="pensum">';
        
            if ($this->myFamily->isSingle())
            {   $this->htmlString   .=  20; }
            else
            {   $this->htmlString   .=  40; }

        //debug_to_console("rows 1, 2, 3 erstellt");
        $this->htmlString   .=  
                    '</div>
                    h
                </div>
                <div class="col col-4"></div>
                <div class="col col-5">
                    <input type="button" onClick="bgQuery(\'' . "INSERT" . '\', ' . ENCODED_T_EINSAETZE . ', 0, 0, '. $this->myFamily->getFamID () .')" value="Eine neue Zeile einfügen"/>
                </div>';    
                
                //<!--<div class="col col-5"><input type="button" value="Zeile entfernen"></div>//-->
        $this->htmlString   .='</li>';
                
        //'<input type="button" onClick="bgQuery(\'' . "DELETE" . '\', ' . ENCODED_T_FAM . ', 0, 0, 0)" value="Markierte Zeilen löschen"/>'
        //'<input type="button" onClick="bgQuery(\'' . "INSERT" . '\', ' . ENCODED_T_FAM . ', 0, 0, 0)" value="Eine neue Zeile einfügen"/>'
        //'<input type="button" onclick=" window.open(\'../mockup/MailTemplate.htm\',\'_blank\')" value="Erinnerungsmail an alle markierten senden"/>'

    }
    
    public function finishTable ()
    {
        $this->htmlString   .=  '</ul>';
    }
    
    public function returnHTML ()
    {   
        $this->finishTable();
        //debug_to_console($this->htmlString);
        return $this->htmlString; 
    }
}
