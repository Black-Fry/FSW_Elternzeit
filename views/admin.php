<?php

include '../classDef/DBclass.php';
include '../classDef/FamilyClass.php';
include '../classDef/HTMLTableClass.php';



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
    
    //print_r($families);   
}


//------------------------



//html page inits
echo ('<!DOCTYPE html>
        <html lang="de">
            <head>
                <meta charset="UTF-8">
                
                <!--  <title>CodePen - Responsive Tables using LI</title>   //-->
                <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
                <link rel="stylesheet" href="../styles/tabStyles.css">
            </head>
            <body translate="no" >
                <div class="container">');

$adminHTMLTab   =   new HTMLTableClass(ADMIN_VIEW);

readFamiliesFromDB($adminHTMLTab);


echo $adminHTMLTab->returnHTML();
       
// html page finals
echo ('         </div>
            </body>
        </html>');