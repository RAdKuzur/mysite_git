var table = document.getElementById("myTable");
var checkboxes = table.getElementsByTagName("input");

for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].id = "checkbox" + (i + 1);
    checkboxes[i].name = "checkbox" + (i + 1);
}
