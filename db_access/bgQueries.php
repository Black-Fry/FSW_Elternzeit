<?php

/* diese Site ist nur dazu da, im Hintergrund SQL-Änderungen durchzuführen und enthält keinerlei "visibles" */

include '../classDef/DBclass.php';

//scheint fehler zu produzieren
function generateUpdateStatement ($_cryptoTabNam, $_fieldToBeUpdated, $_newValue, $_id)
{
    $tabNam = getRealTabNam($_cryptoTabNam);

    //htmlTable liefert leider nur EinsatzZweckNam, NICHT die ID
    if (E_EINSATZ_ZWECK_ID  ==   $_fieldToBeUpdated)
    {   $_newValue  =   resolveEinsatzID ($_newValue);  }
    
    $sql    =   "UPDATE " . $tabNam . " SET `" . $_fieldToBeUpdated . "` = '" . $_newValue
            . "' WHERE `" . getRealIdFieldNam ($tabNam) . "` = " . $_id . ";";
    //debug_to_console($sql);
    return $sql;
}

function resolveEinsatzID($_einsatzNam)
{
    $sql    =   "SELECT " . Z_ZWECK_ID . " FROM " . T_EINSATZ_ZWECKE . " WHERE " . Z_ZWECK_NAME . " = '" . $_einsatzNam . "';";

    $einsatzID  = DBclass::query($sql)->one();  

    return ($einsatzID['' . Z_ZWECK_ID . '']);
}

function generateInsertStatement ($_cryptoTabNam, $_famID)
{
    $tabNam = getRealTabNam ($_cryptoTabNam);
    
    if ($tabNam == T_FAM)
    {   
        $sql    =   "INSERT INTO " . $tabNam . " "
            . "(`" . F_FAM_ID. "`, `" . F_FAM_NAM . "`, `" . F_FAM_CRYPTURL . "`, `" . F_FAM_SINGLE . "`, `" . F_FAM_MAIL_ONE . "`, `" . F_FAM_MAIL_TWO . "`) "
            . " VALUES (NULL, NULL, \"" . generateRandomString() . "\", '0', NULL, NULL);";
    }
    else if ($tabNam == T_EINSAETZE)
    {
        
        //INSERT INTO `Tab_Einsaetze` (`EinsatzID`, `FamID`, `ZweckID`, `EinsatzDate`, `EinsatzLength`, `TimeStamp`, `Kommentar`) VALUES (NULL, '', NULL, NULL, '0.0', CURRENT_TIMESTAMP, NULL);
        $sql    =   "INSERT INTO " . $tabNam . " "
            . "(`" . E_EINSATZ_ID . "`, `" . F_FAM_ID . "`, `" . E_EINSATZ_ZWECK_ID . "`, `" . E_EINSATZ_EINSATZ_DATE . "`, `" . E_EINSATZ_LENGTH . "`, `" . E_EINSATZ_TIME_STAMP . "`, `" . E_EINSATZ_COMMENT . "`) "
            . " VALUES (NULL, " . $_famID . ", 9, NULL, 0.0, CURRENT_TIMESTAMP, NULL);";
        //einsatzZweck 9 = "bitte auswählen"
    }
    
    return $sql;
}

function generateDeleteStatement ($_cryptoTabNam, $_idToBeDeleted)
{
    $tabNam = getRealTabNam($_cryptoTabNam);
    
    //"DELETE FROM `Tab_Familien` WHERE `Tab_Familien`.`FamID` = 28"
    $sql    =   "DELETE FROM " . $tabNam . " WHERE " . getRealIdFieldNam ($tabNam) . "=" . $_idToBeDeleted . ";";
    
    return $sql;
}

function generateRandomString() 
{
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(URL_SECRET_LENGTH/strlen($x)) )),1,URL_SECRET_LENGTH);
}
    
/* funktion löst tabellenname in wirklich sql-tabellennamen auf
 *  übergebener tabellenname ist bewusst entfremdet worden ,weil er 
 * im js in klartext lesbar ist
 */
function getRealTabNam ($_cryptoTabNam)
{
    $tabNam = "";

    switch ($_cryptoTabNam)
    {
       case ENCODED_T_FAM:
           $tabNam  =   T_FAM;
           break;
       case ENCODED_T_EINSAETZE:
           $tabNam  =   T_EINSAETZE;
       default:
           break;
    }

    return $tabNam;
}
   
/* see getRealTabNam () --> name des feldes, dass die iedentifier
 *  in der bd hält, wird bewusst im js entfremdet. hier wird anhand
 *  des tabNams der identifier zurück aufgelöst
 */
function getRealIdFieldNam ($_tabNam)
{
    $idFieldNam = "";

    switch ($_tabNam)
    {
       case T_FAM:
           $idFieldNam  =   F_FAM_ID;
           break;
       case T_EINSAETZE:
           $idFieldNam  =   E_EINSATZ_ID;
       default:
           break;
    }

    return $idFieldNam;
}

//----------------------------

/* funtkion wird immer durch js aufgerufen, sobald ein input den fokus verloren hat
 * deshalb wird auch immer nur ein einizger wert samt feld für eine einzige tabellöe übergeben
 * für das "where" im sql-statement wird noch ein uniue identifier benötigt 
 * (bspw: famTab: famID, einsatzTab: einsID). dessen feldname ergibt sich autom per switch aus 
 * dem tabellennamen
 * http://fsw.ossoelmi.berlin/db_access/bgQueries.php?0=1&1=feld&2=test&3=0815&4=UPDATE
 * 
 * encode vars in URL: $vars = array('email' => $email_address, 'event_id' => $event_id);
 */
header('Content-Type: application/json');

$aResult = array();
$tabNam;
$sql;

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

if( !isset($aResult['error']) ) 
{
    switch($_POST['functionname']) 
    {
        case 'INSERT':
           if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 1) ) 
           {    $aResult['error'] = 'Error in arguments!';  }
           else 
           {
                $sql                = generateInsertStatement($_POST['arguments'][0], $_POST['arguments'][3]);
                //DBClass::connect();
                $aResult['result']  = $sql . " |INSERT| ";
                $aResult['result']  .= DBclass::query($sql)->all();   
           }
           break;
        case 'DELETE':
           if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) 
           {    $aResult['error'] = 'Error in arguments!';  }
           else 
           {
                $idsToBeDeleted     =   json_decode($_POST['arguments'][3]);
                 //DBClass::connect();
                foreach ($idsToBeDeleted as $singleIdToBeDeleted)
                {
                    $sql                = generateDeleteStatement($_POST['arguments'][0], $singleIdToBeDeleted);
                    //$aResult['result']  = $sql . " |DELETE| " . $singleIdToBeDeleted;
                    DBclass::query($sql)->all();   
                }
           }
           break;
        case 'UPDATE':
           if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 4) ) 
           {    $aResult['error'] = 'Error in arguments!';  }
           else 
           {
                $sql                =   generateUpdateStatement($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2], $_POST['arguments'][3]);
                //DBClass::connect();
                $aResult['result']  = $sql . " |UPDATE| ";
                $aResult['result']  .= DBclass::query($sql)->all();   
           }
           break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }
}

echo json_encode($aResult);
