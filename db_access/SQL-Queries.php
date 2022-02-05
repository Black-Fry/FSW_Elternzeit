<?php

# generate Zufallsstirng
# SELECT MD5(RAND()) AS checksumResult;

//new (empty) column into FamilyTab. php generates CryptoURL-String
"INSERT INTO " . T_FAM . " (`FamID`, `FamNam`, `CryptURL`, `Single`, `FamMailOne`, `FamMailTwo`) "
                    . " VALUES (NULL, NULL, \"" . generateRandomString(16) . "\", '0', NULL, NULL);";

//query * from FamilyTab
$families = DBclass::query("SELECT * FROM " . T_FAM . ";\"")->all();

//query einsatzstunden from EinsaetzeTab, ordered by UserEditDate
$famEinsaetzH = DBclass::query("SELECT * FROM " . T_EINSAETZE . " WHERE `FamID` = " . $famObj->getFamID() . " ORDER BY `TimeStamp` DESC;\"")->all();
