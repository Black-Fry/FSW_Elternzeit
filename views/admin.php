<?php

chdir($_SERVER['DOCUMENT_ROOT']);
include 'classDef/DBclass.php';
include 'classDef/FamilyClass.php';
include 'classDef/HTMLTableClass.php';
include_once 'db_access/connection_helper.php';

function generateExcelExportButton ()
{        
    $html   =   "<button onclick='exportAdminTableToExcel(\"adminTable\", \"Export_FSW-Elternzeit_2021\")'>Exportiere nach Excel</button>";
    
    return $html;
}

function readFamiliesFromDB($htmlTableObj)
{       
    DBClass::connect();

    $families = DBclass::query("SELECT * FROM " . T_FAM . ";\"")->all();

    foreach ($families as $family)
    {
        $famObj = new FamilyClass($family);

        //place content into param table - one row per famObj
        $htmlTableObj->addRow($famObj);
    }
    
    $htmlTableObj->addFinalRow();
}


//------------------------ Funktionsaufrufe
//do not use any js/css files from cache.
session_cache_limiter('nocache');

session_start();    /* MUSS AUF ALLEN SEITEN STEHEN - UEBERALL ALS ERSTER BEFEHL !! */
$loginResult    = logged_in();
//print_r($loginResult);
if (! $loginResult) 
{   header('Location: ' . ADMIN_LOGIN_URL); }



//html page inits
echo ('<!DOCTYPE html>
        <html lang="de">
            <head>
                <meta charset="UTF-8">
                <link rel="icon" href="../img/fswFavIcon.png" sizes="32x32" />
                
                <!--  <title>CodePen - Responsive Tables using LI</title>   //-->
                <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
                <!-- <link rel="stylesheet" href="../styles/tabStyles.css"> //-->
                <link rel="stylesheet" href="../styles/adminViewTable.css">
                <link rel="stylesheet" href="../styles/inputGlow.css">
                <link rel="stylesheet" href="../styles/toggleSwitch.css">
                <link rel="stylesheet" href="../styles/snackbar.css">
                <script src="../js/FilterTableByName.js"></script>
                <script src="../js/tableSort.js"></script>
                <script src="../js/callBgQueries.js"></script>
                <script src="../js/tickAllCheckboxes.js"></script>
                <script src="../js/exportTableToExcel.js"></script>           
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            </head>
            <body translate="no" >');

echo ('<div style=text-align:center;>');

//suchfeld zum Durchsuchen der Tabelle
    echo '<input type="text" id="suchFeld" onkeyup="filterByName()" placeholder="Suche nach Namen und E-Mail-Adressen.." title="Gib einen Namen oder eine E-Mail-Adresse ein">';
    echo '<img src="../img/placeholder.png" width="10%" height="1">';
       
//button zum ausloggen
    echo ('<a href="' . LOGOUT_URL . '">Ausloggen</a>');

echo '</div>';

//dropdown zum auswählen des anzuzeigenden jahres
echo ('<div style=text-align:center;>');
echo generateExcelExportButton ();
echo '</div>';
echo '<br>';

$adminHTMLTab   =   new HTMLAdminTableClass();

readFamiliesFromDB($adminHTMLTab);

echo $adminHTMLTab->returnHTML();
//$adminHTMLTab->echoWhoAmI();

//wird nur eingebelndet, wenn ein teXtfeld eine Änderung erfahren und anschließend das Feld den Fokus verloren hat
echo ('<div id="snackbar">Änderung gespeichert!</div>');

// html page finals
echo ('     </body>
        </html>');