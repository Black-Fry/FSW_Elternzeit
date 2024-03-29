<?php

///*  define DB-Access data    */
//const DB_HOST = "your_db-host_here";
//const DB_USERNAME = "your_db-username_here";
//const DB_PASSWORD = "your_db-password_here";
//const DB_NAME = "your_db-name_here";
const DB_HOST = "rdbms.strato.de";
const DB_USERNAME = "dbu783084";
const DB_PASSWORD = "65d01c3d97c81ef2";
const DB_NAME = "dbs5269035";

/*  SQL-Tab-Names    */
const T_FAM = "Tab_Familien";
const T_FAM_2022 = "Tab_Familien_2022";
const T_EINSAETZE = "Tab_Einsaetze";
const T_EINSAETZE_2022 = "Tab_Einsaetze_2022";
const T_ADMIN_USER = "Tab_AdminUser";
const T_EINSATZ_ZWECKE = "Tab_Einsatzzwecke";
const T_EINSATZ_ZWECKE_2022 = "Tab_Einsatzzwecke_2022";

/*  SQL TEST Tab Names  */
define ("T_FAM_TEST", "Tab_Familien_Test");

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
const E_EINSATZ_FAM_ID = F_FAM_ID;
define ("E_EINSATZ_ZWECK_ID", "ZweckID");
define ("E_EINSATZ_EINSATZ_DATE", "EinsatzDate");
define ("E_EINSATZ_LENGTH", "EinsatzLength");
define ("E_EINSATZ_TIME_STAMP", "TimeStamp");
define ("E_EINSATZ_COMMENT", "Kommentar");
define ("U_USER_NAME", "UserName");
define ("U_USER_PASS", "UserPass");
define ("U_USER_SESSION", "UserSession");
define ("U_USER_ID", "UserID");
define ("Z_ZWECK_ID", "ZweckID");
define ("Z_ZWECK_NAME", "ZweckNam");

/*  HTML Table views    */
define ("ADMIN_VIEW", "ADMIN");
define ("USER_VIEW", "USER");

/*  HTML TEST Views */
define ("ADMIN_TEST_VIEW", "ADMIN_TEST");


/*  URL */
// wichtig für potentiell umzüge: die URL wird auch im File callBgQueries.js noch einmal verwendet. dort steht sie hart im code 
define ("ROOT_URL", "http://localhost:63342/FSW_Elternzeit/");
define ("DB_ACCESS_URL", ROOT_URL . "/db_acess");
define ("BG_QUERY_URL", DB_ACCESS_URL . "bgQueries.php");
define ("ADMIN_LOGIN_URL", ROOT_URL . "/views/adminLogin.php");
define ("ADMIN_URL", ROOT_URL . "/views/admin.php");
define ("USER_URL", ROOT_URL . "/views/user.php?cryurl=");
define ("LOGOUT_URL", ROOT_URL . "/views/logout.php");
define ("SEND_MAIL", ROOT_URL . "/mail/prepareAndSendMail.php");
define ("GENERATE_QR", ROOT_URL . "/mail/generateQR.php?id=");

/*  TEST-URLs   */
define ("ADMIN_TEST_LOGIN_URL", ROOT_URL . "/views/adminLogin_test.php");
define ("ADMIN_TEST_URL", ROOT_URL . "/views/admin_test.php");

/* Konstanten   */
define ("PENSUM_SORGERECHT_ALLEIN", 20);
define ("PENSUM_SORGERECHT_GEMEINSAM", 40);
define ("URL_SECRET_LENGTH", 16);
define ("ABGABEDATUM", "31. 07. 2023");

function debug_to_console($data) 
{
    $output = $data;
    if (is_array($output))
    {    $output = implode(',', $output);   }

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

?>