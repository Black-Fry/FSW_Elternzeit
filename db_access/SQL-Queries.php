<?php

# generate Zufallsstring
# SELECT MD5(RAND()) AS checksumResult;

//new (empty) column into FamilyTab. php generates CryptoURL-String
"INSERT INTO " . T_FAM . " (`FamID`, `FamNam`, `CryptURL`, `Single`, `FamMailOne`, `FamMailTwo`) "
                    . " VALUES (NULL, NULL, \"" . generateRandomString(16) . "\", '0', NULL, NULL);";

//DB-Import from Excel
// ="INSERT INTO Tab_Familien (`FamID`, `FamNam`, `CryptURL`, `Single`, `FamMailOne`, `FamMailTwo`) VALUES (NULL, '"&E3&"', SUBSTR(MD5('"&E3&"'), 1, 16) , '0', '"&F3&"', '"&G3&"');"

//query * from FamilyTab
$families = DBclass::query("SELECT * FROM " . T_FAM . ";\"")->all();

//query einsatzstunden from EinsaetzeTab, ordered by UserEditDate
$famEinsaetzH = DBclass::query("SELECT * FROM " . T_EINSAETZE . " WHERE `FamID` = " . $famObj->getFamID() . " ORDER BY `TimeStamp` DESC;\"")->all();
