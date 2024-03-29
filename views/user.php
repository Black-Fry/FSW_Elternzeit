<?php

chdir($_SERVER['DOCUMENT_ROOT']);
include_once 'classDef/DBclass.php';
include_once 'classDef/FamilyClass.php';
include_once 'classDef/EinsatzClass.php';
include_once 'classDef/HTMLTableClass.php';


function decodeFamilyFromURL ()
{
    //wurde die URL ohne CryptGeheimnis aufgerufen? Leite um zum index.php
    if (! $_GET['cryurl']) 
    {   header('Location: ' . ROOT_URL); }
    
    //$sql    =   "SELECT * FROM " . T_FAM . " WHERE  EXISTS (SELECT * FROM " . T_FAM . " WHERE " . F_FAM_CRYPTURL . " = '" . $_GET['cryurl'] . "');";
    $sql    =   "SELECT * FROM " . T_FAM . " WHERE " . F_FAM_CRYPTURL . " = '" . $_GET['cryurl'] . "';";
    //echo ($sql);
    $_dbRow =   DBclass::query($sql)->all();
    //$_dbRow =   DBclass::query($sql)->query();
    
    //wurde die URL mit ungueltigem CryptGeheimnis aufgerufen? Leite um zum index.php
    if (! $_dbRow) 
    {   header('Location: ' . ROOT_URL); }
    
    return (new FamilyClass($_dbRow[0]));
}

function readEinsaetzeFromDB($htmlTableObj, $_famID)
{       
    //DBClass::connect();

    $einsaetze = DBclass::query("SELECT * FROM " . T_EINSAETZE . " WHERE " . F_FAM_ID . " = " . $_famID . ";\"")->all();
    //print_r($einsaetze);
    $i  =   0;
    foreach ($einsaetze as $einsatz)
    {
        //print_r($einsatz);
        $einsatzObj = new EinsatzClass($einsatz);
        //debug_to_console("einsatzObj erstellt");
                
        //place content into param table - one row per famObj
        $htmlTableObj->addRow($einsatzObj);
        $i++;
    }

    
    $htmlTableObj->addFinalRow();
}

function generateExcelExportButton ()
{        
    $html   =   "<button onclick='exportUserTableToExcel(\"Export_FSW-Elternzeit_2022\")'>Exportiere nach Excel</button>";
    
    return $html;
}


//-------------------
$family =   decodeFamilyFromURL ();


echo ('<!DOCTYPE html>
        <html lang="de">
            <head>
                <meta charset="UTF-8">
                <link rel="icon" href="../img/fswFavIcon.png" sizes="32x32" />
                
                <!--  die drei sind fürs tabellendesign:   //-->
                <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
                <link rel="stylesheet" href="../styles/userTabStyles.css">
                <link rel="stylesheet" href="../styles/datepicker.css">');

//Tabellen right-sizing:
echo (' <script>
            window.console = window.console || function(t) {};
        </script>
        <script>
            if (document.location.search.match(/type=embed/gi)) 
            {   window.parent.postMessage("resize", "*");   }
        </script>
    ');
                
echo ('         <link rel="stylesheet" href="../styles/inputGlow.css">
                <link rel="stylesheet" href="../styles/toggleSwitch.css">
                <link rel="stylesheet" href="../styles/snackbar.css">
                <script src="../js/callBgQueries.js"></script>
                <script src="../js/exportTableToExcel.js"></script>  
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            </head>
            <body translate="no" >');

//$family =   decodeFamilyFromURL ();

echo ('<div class="container">
        <p align="left">Arbeitsstundennachweis Schuljahr 2023/2024</p>
        <img src="../img/fswFavIcon.png" width="100"></img>
        <h2>FSW-Elternzeit - Elternansicht</h2>
        
        <p align="center">Familie: <b>' . $family->getFamNam() . ' </b>
            <img src="" height="0" width="100"></img>
            Alleinerziehend (20h):  
                <label class="switch">
                    <input type="checkbox" id="userViewSingle" name="userViewSingle"');
                        
            //aktiviere Checkbox, wenn FamObj == alleinerziehend
            if ($family->isSingle() )
            {   echo (' checked'); }
echo (' onclick="bgQuery(\'' . "UPDATE" . '\', ' . ENCODED_T_FAM . ', \'' . F_FAM_SINGLE . '\', this, ' . $family->getFamID() . ')"><span class="slider"></span>
        </p>');

echo ('<p align="center">Die für Euch hinterlegten E-Mailadressen lauten: <strong>' . $family->getFamMail(1) . '</strong> sowie <b>' . $family->getFamMail(2) . '</b></p>');
echo ('<br>
        <!--<p>(Erläuterungen und Ausfüllhinweise siehe <a href="">unten</a>)</p>//-->
        <br>');
echo ('<div style=text-align:center;>');
echo generateExcelExportButton ();
echo '</div><br>';


$userHTMLTab   =   new HTMLUserTableClass($family);
//debug_to_console("generated user tab");

readEinsaetzeFromDB($userHTMLTab, $family->getFamID());
//debug_to_console("gathered all einsatz from db");

echo $userHTMLTab->returnHTML();

echo ('Ihr wollt den Quellcode untersuchen oder das Projekt verbessern? F&uuml;hlt Euch herzlich dazu eingeladen, alles wurde ver&ouml;ffentlicht im <a href="https://github.com/Black-Fry/FSW_Elternzeit" target="_blank">GitHub</a>');

//wird nur eingebelndet, wenn ein teXtfeld eine Änderung erfahren und anschließend das Feld den Fokus verloren hat
echo ('<div id="snackbar">Änderung gespeichert!</div>');

// html page finals
echo ('     </body>
        </html>');
