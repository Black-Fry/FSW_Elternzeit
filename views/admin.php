<?php

include '../classDef/DBclass.php';
include '../classDef/FamilyClass.php';
include '../classDef/HTMLAdminTableClass.php';



function readFamiliesFromDB($htmlTableObj)
{       
    DBClass::connect();

    $families = DBclass::query("SELECT * FROM " . T_FAM . ";\"")->all();
    
    foreach ($families as $family)
    {
        //print_r($family);
        $famObj = new FamilyClass($family);
        
        //read Stunden pro Family from DB
        $famEinsaetzH = DBclass::query("SELECT * FROM " . T_EINSAETZE . " WHERE `FamID` = " . $famObj->getFamID() . " ORDER BY `TimeStamp` DESC;\"")->all();
        $famObj->calculateStundenFromDB($famEinsaetzH);
        
        //place content into param table - one row per famObj
        $htmlTableObj->addRow($famObj);
    }

    $htmlTableObj->addFinalRow();
}


//------------------------ Funktionsaufrufe

//do not use any js/css files from cache.
session_cache_limiter('nocache');

//html page inits
echo ('<!DOCTYPE html>
        <html lang="de">
            <head>
                <meta charset="UTF-8">
                
                <!--  <title>CodePen - Responsive Tables using LI</title>   //-->
                <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
                <!-- <link rel="stylesheet" href="../styles/tabStyles.css"> //-->
                <link rel="stylesheet" href="../styles/adminViewTable.css">
                <link rel="stylesheet" href="../styles/inputGlow.css">
                <link rel="stylesheet" href="../styles/toggleSwitch.css">
                <script src="../js/FilterTableByName.js"></script>
                <script src="../js/tableSort.js"></script>
                <script src="../js/callBgQueries.js"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            </head>
            <body translate="no" >');


//echo "<div>hi</div>";
echo ('<div>'
        . '<input type="text" id="suchFeld" onkeyup="filterByName()" placeholder="Suche nach Namen und E-Mail-Adressen.." title="Gib einen Namen oder eine E-Mail-Adresse ein">'
        . '</div>');

$adminHTMLTab   =   new HTMLAdminTableClass();

readFamiliesFromDB($adminHTMLTab);

echo $adminHTMLTab->returnHTML();
//$adminHTMLTab->echoWhoAmI();

//button js test
echo ('<button onclick="bgQuery()">Click me</button>');
       
// html page finals
echo ('     </body>
        </html>');