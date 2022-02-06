<?php


/*  define DB-Access data    */
define ("DB_HOST", "rdbms.strato.de");
define ("DB_USERNAME", "dbu783084");
define ("DB_PASSWORD", "65d01c3d97c81ef2");
define ("DB_NAME", "dbs5269035");

/*  SQL-Tab-Names    */	
define ("T_FAM", "Tab_Familien");
define ("T_EINSAETZE", "Tab_Einsaetze");

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

/*  HTML Table views    */
define ("ADMIN_VIEW", "ADMIN");
define ("USER_VIEW", "USER");

/*  URL */
// wichtig für potentiell umzüge: die URL wird auch im File callBgQueries.js noch einmal verwendet. dort steht sie hart im code 
define ("ROOT_URL", "http://fsw.ossoelmi.berlin");
define ("DB_ACCESS_URL", ROOT_URL . "/db_acess");
define ("BG_QUERY_URL", DB_ACCESS_URL . "bgQueries.php");

/* Konstanten   */
define ("PENSUM_SORGERECHT_ALLEIN", 20);
define ("PENSUM_SORGERECHT_GEMEINSAM", 40);
define ("URL_SECRET_LENGTH", 16);

?>
