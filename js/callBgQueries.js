//function is not in use
function bgQuery_old() 
{
    //* http://fsw.ossoelmi.berlin/db_access/bgQueries.php?0=1&1=feld&2=test&3=0815&4=UPDATE    
    //var str = "0=1&1=feld&2=test&3=0815&4=UPDATE";    //on bgCall & POST no "?" required?
    var str = "?0=1&1=feld&2=test&3=0815&4=UPDATE";
    //var url = "<?php echo BG_QUERY_URL; ?>";
    var url = "http://fsw.ossoelmi.berlin/db_access/bgQueries.php"; //no ? required

    xmlReq=new XMLHttpRequest();

    xmlReq.open("POST",url,true);
    xmlReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlReq.setRequestHeader("Content-length", str.length);
    xmlReq.setRequestHeader("Connection", "close");
    xmlReq.send(str);
    console.log("done");
    
    window.open(url+str, '_blank').focus();
    
    alert(str);
}

//receive args: sql-cmd, cryptoTabNam, field2Bupdated, newValue, id
function bgQuery(_sqlCmd, _cryptoTab, _fieldnam, _newValue, _id)
{
    //sqlCmd          = 'UPDATE';
    //cryptoTabNam    = 1;
    //fieldnam        = "FamNam";
    //newValue        = "Hans";
    //id              = 9;
    
    // wenn leere Zeilen gelöscht werden sollen, dann kann js die ids selbst aus DOM & "checked" Inputs finden
    if ( _sqlCmd === 'DELETE') 
    {  _id =   JSON.stringify(gatherAllCheckedRows()); }
    
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
                //show "success within toast;
                console.log(obj.result);
                if ( (_sqlCmd === 'INSERT') || (_sqlCmd === 'DELETE') )
                {   
                    var url = "http://fsw.ossoelmi.berlin/views/admin.php";
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
   
//alert wenn Stunden != 0!
function gatherAllCheckedRows()
{ 
    var checkedFields       = document.querySelectorAll('input[type="checkbox"]:checked');   
    const paramArray        = [];
    var zeroHourWatchDog    =   false;
    
    for (i=0; i<checkedFields.length; i++)
    {
        var idString = String(checkedFields.item(i).id);
        
        //es gibt ein weiteres Checkbox-Element: "Alleinstehend" (single). Das brauchen wir hier nicht
        if ( idString.includes("single") )
        {   continue;   }
        else
        {
            const stringSplit   = idString.split('_');
            var geleisteteStunden   = parseInt(stringSplit[2]);  
                        
            if ( 0 === geleisteteStunden )
            {   paramArray.push(stringSplit[1]);  }
            else
            {   zeroHourWatchDog    =   true;   }
        }
    }
    
    if (zeroHourWatchDog)
    {   alert("Es dürfen nur Zeilen gelöscht werden, in denen noch keine Stunden geleistet wurden.\n\
                Soll eine andere Zeile gelöscht werden, bitte kontaktiere die/den Admin!");    }
    
    return paramArray;
}
