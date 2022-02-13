<?php

include '../db_access/common.php';
include '../classDef/DBclass.php';
include '../classDef/FamilyClass.php';
include '../classDef/MailClass.php';

//------------------------------------------------------------

header('Content-Type: application/json');

$aResult = array();

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No Family IDs!'; }

if( !isset($aResult['error']) ) 
{
    $families   =   json_decode($_POST['arguments']);
    
    foreach ($families as $familyID)
    {   
        //array_push($aResult['result'], $familyID);   
        $mailObj    =   new MailClass($familyID);
            $mailObj->sendMail();
        //$aResult['result'] = $mailObj->getText();    
    }

    $aResult['result'] = count($families);
}

echo json_encode($aResult);

