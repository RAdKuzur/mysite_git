document.getElementById('button-1').addEventListener('click', function() {
    var element = document.getElementById('div-1');
    if (element.style.display == 'none') {
        element.style.display = 'block';
    } else {
        element.style.display = 'block';
    }
});
document.getElementById('button-1').onclick = function() {
    document.getElementById('table-1').hidden = true;
    document.getElementById('div-1').hidden = false;
}
