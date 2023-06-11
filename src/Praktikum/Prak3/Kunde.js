'use strict'

let request = new XMLHttpRequest();
function requestData() {
    request.open("GET", "Kunde.php");
    request.onreadystatechange = processData;
    request.send();
}

function processData() {

}