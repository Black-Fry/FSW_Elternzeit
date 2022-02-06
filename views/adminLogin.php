<?php

include_once '../db_access/connection_helper.php'; 


$user       =   "user_input";
$pw         =   "pw_input";
$login_btn  =   "login_btn";


session_start();    /* MUSS AUF ALLEN SEITEN STEHEN - UEBERALL ALS ERSTER BEFEHL !! */

/*
function newUserRegistered ()
{
    if (isset($_GET['newUserSuccess']))
    {   return ("<p class='na'>Neuer Benutzer " . $_GET['newUserSuccess'] . " wurde erfolgreich erstellt</p><hr>");  }
    if (isset($_GET['q']))
    {   return ("<p class='na'>Neues Passwort fuer den Benutzer " . $_GET['q'] . " wurde erfolgreich erstellt</p><hr>");  }    
}
*/

if (isset($_POST[$login_btn])) 
{ 
    $userid=check_user($_POST[$user], $_POST[$pw]); 
    //debug_to_console ($userid);
    if ($userid!=false) 
    {   login($userid); }
    else 
    {   echo "<p class='na'>Deine Anmeldedaten waren nicht korrekt! (user: $_POST[$user])</p><hr>";  }
}


if (!logged_in()) 
{    
    $htmlHeader     =   "<html><head><title>Admin-Anmeldemaske der FSW-Elternstundenverwaltung</title>";
    $htmlHeader     .=      '<link rel="icon" href="../img/fswFavIcon.png" sizes="32x32" />';
    $htmlHeader     .=  '</head><body>';    
    echo ($htmlHeader);
    
    $alignCenter    =   "<table border='0' width='100%' height='100%'><tr align='center'><td>";
    
    //echo newUserRegistered();
        
    $form   =   '
                <form method="post" action="' . ADMIN_LOGIN_URL . '">
                    <table class="loginTab">
                        <tr>
                            <td class="text_label"><p class="na">Benutzername</p></td>
                            <td class="input_field">
                                <input type="text" id='.$user.' name='.$user.' enabled></input>
                            </td>
                        </tr>
                        <tr>
                            <td class="text_label"><p class="na">Passwort</p></td>
                            <td class="input_field">
                                <input type="password" id='.$pw.' name='.$pw.' enabled></input>
                            </td>
                        </tr>
                        <tr>
                            <td class="login_btn" colspan="2">
                                <input type="submit" id='.$login_btn.' name='.$login_btn.' value="login" enabled></input>
                            </td>
                        </tr>
                </form>';
    
    $alignCenter    .=  $form;
    
    /*$html   =       "<tr align='center'>"
            .           "<td colspan='2'>"
            .               "<br>"
            .                   "<a href='" . $newUserURL . "' class='button-styled-link'>noch nicht registriert? Erstelle hier einen neuen Benutzer</a>"
            .               "<br><br>"	
            .                   "<a href=" . $regelwerkURL . " target='blank' class='button-styled-link'>Regelwerk (V 0.96 [2016-06-15])</a>"
            .           "</td>"
            .       "</tr>";*/

    $html   .=   "</table>";
    
    $alignCenter    .=  $html;
    
    $alignCenter    .=  "</td></tr></table>";
    echo ($alignCenter);
}
else 
{   header('Location: ' . ADMIN_URL);    }