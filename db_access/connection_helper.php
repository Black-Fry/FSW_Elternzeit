<?php

include_once 'db_access/common.php';
include_once 'classDef/DBclass.php';

function check_user($name, $pass) 
{ 
    //echo $name;
    $sql    =   "SELECT " . U_USER_ID 
            .   " FROM " . T_ADMIN_USER 
            .   " WHERE " . U_USER_NAME . " = '" . utf8_decode($name) . "' AND " . U_USER_PASS . "='".md5($pass)."'"
            .   " LIMIT 1;"; 
    //$result =   mysql_query($sql) or die(mysql_error()); 
    $result =   DBclass::query($sql)->all();
    $userid   =   $result[0][U_USER_ID];
    //debug_to_console(print_r($result));
    if ($userid)
    {   return $userid;  } 
    else    {   return false;   }
}
        
    
function login ($userid) 
{ 
    $sql    =   "UPDATE " . T_ADMIN_USER
            . " SET " . U_USER_SESSION . "='" . session_id() . "'"
            . " WHERE " . U_USER_ID . "='" . $userid . "';"; 
    //debug_to_console(print_r($userid));
    //debug_to_console($sql);
    DBclass::query($sql)->all();
}   

function logged_in() 
{
    $sql    =   "SELECT " . U_USER_ID . "," . U_USER_NAME
            .   " FROM " . T_ADMIN_USER
            .   " WHERE " . U_USER_SESSION . "='" . session_id() . "' LIMIT 1";

    //$result=mysql_query($sql); 
    // debug_to_console($sql);
    $result =   DBclass::query($sql)->all();
    //debug_to_console(print_r($result));
    $userID =   $result[0][U_USER_ID];
    //debug_to_console($userID);
    if ( $userID )
    //{  return ( mysql_fetch_assoc($result) ); }
    {   return ( $userID );    }
    else                                
    {   return false;    }
}  


function logout() 
{ 
    $sql    =   "UPDATE " . T_ADMIN_USER . "
                    SET " . U_USER_SESSION . "=NULL 
                    WHERE " . U_USER_SESSION . "='" . session_id() . "'"; 

    DBclass::query($sql)->all();
}     
    