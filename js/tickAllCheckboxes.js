
function tickCheckBoxes ()
{ 
    var checkBoxes  = document.querySelectorAll('input[type="checkbox"]');   
    var on_off      = false;
    
    if (true === document.getElementById('tickAll').checked)
    {   on_off  =   true;  }
    else
    {   on_off  =   false;  }
    
    
    for (i=0; i<checkBoxes.length; i++)
    {
        var idString = String(checkBoxes.item(i).id);
        //alert (idString);
        //es gibt ein weiteres Checkbox-Element: "Alleinstehend" (single). Das brauchen wir hier nicht
        if ( idString.includes("single") )
        {   continue;   }
        else
        {   document.getElementById(idString).checked    =   on_off;    }
    }
    
}
