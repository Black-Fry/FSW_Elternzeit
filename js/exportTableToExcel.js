
function exportAdminTableToExcel(tableID, filename = ''){
    var downloadLink;
    
    //bastele Tabelle zusammen, beginne mit Tabellenkopf
    var tableHTML = "Name"; //Zelle A1
    tableHTML += "\t" + document.getElementsByTagName("th")[2].firstChild.data; //B1
    tableHTML += "\t" + document.getElementsByTagName("th")[3].firstChild.data; //C1
    tableHTML += "\t" + document.getElementsByTagName("th")[4].firstChild.data; //D1
    tableHTML += "\t" + document.getElementsByTagName("th")[5].firstChild.data; //E1
    tableHTML += "\t" + "Pensum erfüllt";                                      //F1
    tableHTML += "\t" + document.getElementsByTagName("th")[7].firstChild.data; //G1
    
    var t = document.getElementById("adminTable");
    var trs = t.getElementsByTagName("tr");
    var tds = null;

    for (var i=0; i<trs.length; i++)
    {       
        //Schlusszeile wird nicht benötigt
        if ( i === (trs.length-1) )
        {   break;  }
        
        tds = trs[i].getElementsByTagName("td");
        
        //Zeile ist leer?
        if (!tds)   {   continue;   }
        
        tableHTML += "\n";
        
        for (var n=0; n<tds.length; n++)
        {
            //ueberspringe Checkboxen und für den Excelexport unnoetige Zellen
            if ( (n === 0) || (n === 8) )
            {   continue;  }
            
            //Name, Mail 1 oder Mail 2?
            else if ( (n === 1) || (n === 3) || (n === 4) )
            {
                //tds[n].onclick=function() { alert(this.innerHTML); }
                console.log(tds[n].getElementsByTagName("input")[0].value);
                tableHTML += tds[n].getElementsByTagName("input")[0].value + "\t";
            }
            
            //Alleinerziehend?
            else if( n === 2)
            {               
                if (true === tds[n].getElementsByTagName("input")[0].checked)
                {   tableHTML += "ja" + "\t";  }
                else
                {   tableHTML += "nein" + "\t";  }
            }
            
            //lies geleistete Stunden aus a href aus und ersetze "." durch "," fürs Excel
            else if ( n === 5 )
            {
                var geleisteteStunden = tds[n].getElementsByTagName("a")[0].innerHTML;
                
                //Feld ist leer, wenn Stunden = 0 - daher bringe String "0" ins Excel
                if (0 < geleisteteStunden)
                {   tableHTML += geleisteteStunden.replace(".", ",") + "\t";  }
                else
                {   tableHTML += "0" + "\t";  }
            }
            
            //Pensum erfüllt? Werte "unsichtbare" TD aus
            else if ( n === 6)
            {
                var pensum = tds[n].getElementsByTagName("p")[0].innerHTML;
                
                if ( 0 < pensum )
                {   
                    //console.log("nein");    
                    tableHTML += "nein" + "\t";
                }
                else
                {   
                    //console.log("ja");      
                    tableHTML += "ja" + "\t";
                }
                
                //console.log("tr = " + i  + ", td = " + n + "content: " + tds[n].innerHTML + "\t");
            }
            
            //letzte Änderung am?
            else if ( n === 7)
            {   tableHTML += tds[n].getElementsByTagName("p")[0].innerHTML + "\t";  }
                       
            else
            {
                console.log("tr = " + i  + ", td = " + n + "content: " + tds[n].innerHTML + "\t");
                tableHTML += "\t";      //drin lassen, damit die weiteren Zellen im Excel richtig befuellt werden
            }
        }
    }
   
    tableHTML += "\n" + "exportiert am: " + new Date(Date.now()) ;
   
    //console.log(tableHTML);
   
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
        
    //var dataType = 'application/vnd.ms-excel';
    //var dataType = 'text/html';
   var dataType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    //var tableSelect = document.getElementById(tableID);        
      
    /*  READMEs
     *  https://codepen.io/gildata/pen/rGrEXQ
     *  https://bueltge.de/wp-content/download/wk/utf-8_kodierungen.pdf
     *  https://floern.com/;;/umlautproblem/
     */
   
   tableHTML = ersetzeUmlaute(tableHTML);
   
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob([tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }    
}

function exportUserTableToExcel(filename = '')
{
    var downloadLink;
    
    //bastele Tabelle zusammen, beginne mit Tabellenkopf
    var tableHTML = "";
    tableHTML += document.getElementsByClassName("col col-2")[0].innerHTML; //A1
    tableHTML += "\t" + document.getElementsByClassName("col col-3")[0].innerHTML; //B1
    tableHTML += "\t" + document.getElementsByClassName("col col-4")[0].innerHTML; //C1
    tableHTML += "\t" + document.getElementsByClassName("col col-5")[0].innerHTML; //C1
    tableHTML += "\n";
    
    var cols2 = document.getElementsByClassName("col col-2");
    var cols3 = document.getElementsByClassName("col col-3");
    var cols4 = document.getElementsByClassName("col col-4");
    var cols5 = document.getElementsByClassName("col col-5");
    
    for (var i = 1; i < (cols2.length-1); i++)
    {       
        if ("0" === cols3[i].getElementsByTagName("select")[0].value)
        {   continue;   }
        
        tableHTML += cols2[i].getElementsByTagName("input")[0].value;
        tableHTML += "\t" + cols3[i].getElementsByTagName("select")[0].value.replaceAll('.', ",");  //Excel interpretiert "." als Datumsangabe
        tableHTML += "\t" + cols4[i].getElementsByTagName("textarea")[0].value.replaceAll('#', "").replaceAll('\n', ". "); //#bricht TextEinselen ab - warum?
        tableHTML += "\t" + cols5[i].getElementsByTagName("select")[0].value;
        //tableHTML += "\t" + cols3[i].innerHTML;
        
        tableHTML += "\t" + i + "\n";
    }
    

    tableHTML += "\n" + "exportiert am: " + new Date(Date.now()) ;
   
    console.log(tableHTML);
   
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
        
    //var dataType = 'application/vnd.ms-excel';
    //var dataType = 'text/html';
   var dataType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    //var tableSelect = document.getElementById(tableID);        
      
   
   tableHTML = ersetzeUmlaute(tableHTML);
   
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob([tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }    
}


function ersetzeUmlaute (inString)
{
    // Ü, ü     \u00dc, \u00fc
    // Ä, ä     \u00c4, \u00e4
    // Ö, ö     \u00d6, \u00f6
    // ß        \u00df
    
    inString = inString.replaceAll('Ä', "Ae");
    inString = inString.replaceAll('Ö', "Oe");
    inString = inString.replaceAll('Ü', 'Ue');
    inString = inString.replaceAll('ä', "ae");
    inString = inString.replaceAll("ö", "oe");
    inString = inString.replaceAll("Ã¼", "0");     //ü
    inString = inString.replaceAll("ü", "ue"); 
    inString = inString.replaceAll("%C3%BC", "2"); //ü
    
    return inString;
}
