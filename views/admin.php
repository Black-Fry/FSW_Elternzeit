<?php

include '../classDef/DBclass.php';
//include '../classDef/FamClass.php';
//include '../classDef/HTMLTableClass.php';

echo "ho";


function readFamiliesFromDB()
{
    DBClass::connect();

    $families = DBclass::query("SELECT * FROM Tab_Familien")->all();
    print_r($families);
    
    /*
    $sqlFamilies  = Db::"SELECT * FROM Tab_Familien;";
    $resFamilies  = $dbobj->query($sqlFamilies) or die(mysqli_error());

    $families     = $resFamilies->fetch_assoc();
    
    foreach($families AS $family) 
    {
        echo $familiy[FamID].", ".$familiy[CryptURL].",".$familiy[Single].", ".$familiy[FamMailOne].", ".$familiy[FamMailTwo];
    }

    return ($families);
     * */
    
}


//------------------------

readFamiliesFromDB();