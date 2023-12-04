
/*var table = document.getElementById("productName");
var options = table.getElementsByTagName("option");
for (var i = 0; i < options.length; i++) {
    options[i].id = "option" + (i + 1);
    options[i].name = "option" + (i + 1);
}
*/
document.getElementById('button-1').addEventListener('click', function() {
    var element = document.getElementById('div-1');
    if (element.style.display == 'none') {
        element.style.display = 'block';
    } else {
        element.style.display = 'block';
    }
});
document.getElementById('button-1').onclick = function() {
    //document.getElementById('table-1').hidden = true;
    document.getElementById('div-1').hidden = false;
}
