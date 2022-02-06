
function filterByName() 
{  
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("suchFeld");
  filter = input.value.toUpperCase();
  table = document.getElementById("adminTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) 
  {      
    //[0] steht fuer das hidden td, siehe TableClass
    td = tr[i].getElementsByTagName("td")[0];
    if (td) 
    {
      txtValue = td.textContent || td.innerText;
      //txtValue = td.getElementsByTagName("input").value;
      //txtValue = td.find("input[type='text']").value;
      if (txtValue.toUpperCase().indexOf(filter) > -1) 
      {
        tr[i].style.display = "";
      } else 
      {
        tr[i].style.display = "none";
      }
    }
  }
}
