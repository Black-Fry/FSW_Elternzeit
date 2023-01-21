<?php
    chdir($_SERVER['DOCUMENT_ROOT']);
    session_start(); 

    include_once 'db_access/common.php';
    include_once 'db_access/connection_helper.php';
    

    $htmlHeader = "<html><head><title>FSW Elternzeit - Logout</title>"
                .    "</head><body>";    


    $alignCenter    =   $htmlHeader;
    $alignCenter    .=   "<table border='0' width='100%' height='100%'><tr align='center'><td>";

    logout(); 

    $alignCenter    .=  '<p class="na">Du bist '; 
    if (!logged_in()) 
    {   $alignCenter    .=  'nicht ';   }
    $alignCenter    .=  'eingeloggt.</p>'; 

    $alignCenter    .=  "<a href=" . ADMIN_LOGIN_URL . ">Einloggen</a>"; 

    $alignCenter    .=  "</td></tr></table>";

    echo ($alignCenter);