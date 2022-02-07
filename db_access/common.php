<?php


/*  define DB-Access data    */
define ("DB_HOST", "");
define ("DB_USERNAME", "");
define ("DB_PASSWORD", "");
define ("DB_NAME", "");

/*  SQL-Tab-Names    */	
define ("T_FAM", "Tab_Familien");
define ("T_EINSAETZE", "Tab_Einsaetze");
define ("T_ADMIN_USER", "Tab_AdminUser");

/* Dekodierte SQL-Tabellennamen - werden per JS in .onChange() ausgetauscht und sollen nicht im Klartext sichtbar sein */
define ("ENCODED_T_FAM", 1);
define ("ENCODED_T_EINSAETZE", 2);


/*  SQL-Tab-Field-Names    */	
define ("F_FAM_ID", "FamID");
define ("F_FAM_NAM", "FamNam");
define ("F_FAM_CRYPTURL", "CryptURL");
define ("F_FAM_SINGLE", "Single");
define ("F_FAM_MAIL_ONE", "FamMailOne");
define ("F_FAM_MAIL_TWO", "FamMailTwo");
define ("E_EINSATZ_ID", "EinsatzID");
define ("U_USER_NAME", "UserName");
define ("U_USER_PASS", "UserPass");
define ("U_USER_SESSION", "UserSession");
define ("U_USER_ID", "UserID");

/*  HTML Table views    */
define ("ADMIN_VIEW", "ADMIN");
define ("USER_VIEW", "USER");

/*  URL */
// wichtig für potentiell umzüge: die URL wird auch im File callBgQueries.js noch einmal verwendet. dort steht sie hart im code 
define ("ROOT_URL", "http://fsw.ossoelmi.berlin");
define ("DB_ACCESS_URL", ROOT_URL . "/db_acess");
define ("BG_QUERY_URL", DB_ACCESS_URL . "bgQueries.php");
define ("ADMIN_LOGIN_URL", ROOT_URL . "/views/adminLogin.php");
define ("ADMIN_URL", ROOT_URL . "/views/admin.php");

/* Konstanten   */
define ("PENSUM_SORGERECHT_ALLEIN", 20);
define ("PENSUM_SORGERECHT_GEMEINSAM", 40);
define ("URL_SECRET_LENGTH", 16);
define ("ABGABEDATUM", "01. 01. 1971");

function debug_to_console($data) 
{
    $output = $data;
    if (is_array($output))
    {    $output = implode(',', $output);   }

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

?>
