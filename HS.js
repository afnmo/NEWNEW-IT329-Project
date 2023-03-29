function myFunction() {
  var input, filter, table, tr, td, i,j;
  input = document.getElementById("mylist");
  filter = input.value.toUpperCase();
  //from drop down
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");//take all value in table
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];//show only match and one for catogry
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) >-1) {
        tr[i].style.display = "";
 }
      else {
        tr[i].style.display = "none";
      }

    }       
  }
}
function deleteRow(r){
       var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("RH").deleteRow(i);}


   