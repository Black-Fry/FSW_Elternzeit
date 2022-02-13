//receive args: sql-cmd, cryptoTabNam, field2Bupdated, newValue, id
function bgQuery(_sqlCmd, _cryptoTab, _fieldnam, _newValue, _id)
{   
    
    aktualisiereEinsatzDauerSumme(_fieldnam);
    
    // wenn leere Zeilen gelöscht werden sollen, dann kann js die ids selbst aus DOM & "checked" Inputs finden
    if ( _sqlCmd === 'DELETE') 
    {  
        alarm      =   true;   //gib einen js.alarm, wenn felder mit "geleistete Stunden != 0" markiert worden sind (DELETE)
        countFamIDs =   false;  //brauchen wir hier nicht. wir wollen zeile(n) in Abhängigkeit der geleisteten Stunden löschen
        countHours  =   true;   //das wollen wir
        _id =   JSON.stringify(gatherAllCheckedRows(alarm, countFamIDs, countHours)); 
        console.log(_id);
    }
    
    // lies wert des upgedateten Text-Inputs. param '_newValue' transportiert id, mit derne Hilfe
    //  per js/DOM der aktuelle wert ausgelesen werden kann
    if ( _sqlCmd === 'UPDATE') 
    {   
        //get value from dom

        //aufruf kommt von element aus userview? dort muss "on"/"off" nach "1/0" ersetzt werden
        if ("userViewSingle" === _newValue.name)
        {
            switch (document.getElementById(_newValue.name).checked)
            {
                case true:
                    _newValue   =   '1';
                    document.getElementById('pensum').innerHTML   =   "20";
                    break;
                case false:
                    _newValue   =   "0";
                    document.getElementById('pensum').innerHTML   =   "40";
            }
        }
        //aufruf kommt aus admin view. kein translate noetig
        else
        {   
            _newValue   = document.getElementById(_newValue.name).value;    
            //console.log(_newValue);
        }
        
        
    }
    
    //alert (_sqlCmd + ", " + _cryptoTab + ", " +  _fieldnam + ", " +  _newValue + ", " + _id);
    
    jQuery.ajax(
    {
        type: "POST",
        url: "http://fsw.ossoelmi.berlin/db_access/bgQueries.php",
        dataType: 'json',
        //arguments: cryptnoTabNam, fieldNam, newValue, id
        //data: {functionname: arguments[0], arguments: [arguments[1], fieldnam, newValue, id]},
        data: {functionname: _sqlCmd, arguments: [_cryptoTab, _fieldnam, _newValue, _id]},

        //success: function (obj, textstatus) 
        success: function (obj) 
        {
            if( !('error' in obj) ) 
            {   
                console.log(obj.result);
                
                //show "success within toast;
                if ( _sqlCmd === 'UPDATE' )
                {   
                    console.log("UPDATE");
                    // Get the snackbar DIV
                    var x = document.getElementById("snackbar");

                    // Add the "show" class to DIV
                    x.className = "show";

                    // After 3 seconds, remove the show class from DIV
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                }               
                
                //reload page
                if ( (_sqlCmd === 'INSERT') || (_sqlCmd === 'DELETE') )
                {   
                    var url = window.location.href;
                    window.open(url, "_self");
                }
            }
            else 
            {
                //output error in toast
                console.log(obj.error);
            }
        }
    });
}
   
//param: _alarm (bool)! Wird benötigt, falls Zeilen gelöscht werden sollen, deren Stunden != 0!
//bool: _countBoxes, _countHours: entscheiden, ob Fktn "geleistete Stunden" einer Zeile oder deren FamID zurück gibt
function gatherAllCheckedRows(_alarm, _countFamIDs, _countHours)
{ 
    var checkedFields       = document.querySelectorAll('input[type="checkbox"]:checked');   
    const paramArray        = [];
    var zeroHourWatchDog    =   false;
    
    for (i=0; i<checkedFields.length; i++)
    {
        var idString = String(checkedFields.item(i).id);
        
        //(1) es gibt ein weiteres Checkbox-Element: "Alleinstehend" (single). Das brauchen wir hier nicht
        //(2) und es gibt die CheckBox "checkAllBoxes" Feld aus Admin-View. Wird auch nicht benoetigt
        if ( idString.includes("single") || idString.includes("tickAll") )
        {   continue;   }
        else if ( (true === _countHours) && (false === _countFamIDs) )
        {
            const stringSplit   = idString.split('_');
            var geleisteteStunden   = parseInt(stringSplit[2]); 
            console.log(geleisteteStunden);
                  
            //wenn keine Stunde eingegebn wurde, erkennt js "NaN"
            if ( ! geleisteteStunden )
            {   
                paramArray.push(stringSplit[1]);  
                //console.log(stringSplit[1]);
            }
            else
            {   
                zeroHourWatchDog    =   true;   
                //console.log(stringSplit[1] + " sets watchDog = true" + ", geleisteteStunden = " + geleisteteStunden);
            }
        }
        else if ( (true === _countFamIDs) && (false === _countHours) )
        {
            const stringSplit   = idString.split('_');
            paramArray.push(parseInt(stringSplit[1])); 
        }
    }
    
    if ( (true === zeroHourWatchDog) && (true === _alarm) )
    {   alert("Es dürfen nur Zeilen gelöscht werden, in denen noch keine Stunden geleistet wurden.\n\Soll eine andere Zeile gelöscht werden, bitte kontaktiere die/den Admin!");    }
    
    return paramArray;
}

//function wird nur auf PullDown "EinsatzLength" angewendet & summiert die neue Einsatzlaenge auf die TabFußzeile
function aktualisiereEinsatzDauerSumme (_fieldname)
{
    //console.log(_fieldname);
    
    if ( (String(_fieldname)).includes("EinsatzLength"))
    {    
        console.log("got it");
        
        var stundenFelder   = document.querySelectorAll('[id^="EinsatzLength_"]');   
        var stundenGesamt   = 0;
        
        //console.log(stundenFelder.length);

        for (i=0; i<stundenFelder.length; i++)
        {
            var stunden = parseInt(stundenFelder.item(i).value);
            stundenGesamt = stundenGesamt   +   stunden;
            //console.log(stundenFelder.item(i).value);
        }

        document.getElementById('summe_stunden').innerHTML   =   stundenGesamt;
    }
}

//prepare mails to be sent. param: none
// famId(s) kommen aus gatherAllCheckedRows()
function prepareMails()
{     
    alarm       =   false;      //kein Alarm benötigt
    countFamIDs =   true;       //brauchen wir hier
    countHours  =   false;      //das wollen wir nicht
    famIDs      =   JSON.stringify(gatherAllCheckedRows(alarm, countFamIDs, countHours));
    //console.info(famIDs);
    
    jQuery.ajax(
    {
        type: "POST",
        url: "http://fsw.ossoelmi.berlin/mail/prepareAndSendMail.php",
        dataType: 'json',
        data: {arguments: famIDs},

        success: function (obj) 
        {
            if( !('error' in obj) ) 
            {   
                console.log(obj.result);
                
                //show "success within toast;
                var x = document.getElementById("snackbar");

                // Add the "show" class to DIV
                x.innerHTML     = "Mails gesendet";
                x.className     = "show";

                // After 3 seconds, remove the show class from DIV
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
            else 
            {
                //output error in toast
                console.log(obj.error);
            }
        }
    });
}

