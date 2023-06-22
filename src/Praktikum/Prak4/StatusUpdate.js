'use strict'

function processData(jsonFile) {
    const data = JSON.parse(jsonFile);

    if (!data || data.length === 0) {
        console.error("No pizza data found.");
        return;
    }

    let array_article_id  = []
    let array_article_status = []

    document.getElementById("article_info_name").textContent = data.article_id;
    document.getElementById("article_info_status").textContent = data.article_status;
}

// request als globale Variable anlegen (haesslich, aber bequem)
var request = new XMLHttpRequest();

function requestData() { // fordert die Daten asynchron an
    request.open("GET", "KundenStatus.php"); // URL für HTTP-GET
    request.onreadystatechange = processData; //Callback-Handler zuordnen
    request.send(null); // Request abschicken
}

 function processData() {
    if(request.readyState == 4) { // Uebertragung = DONE
        if (request.status == 200) {   // HTTP-Status = OK
            if(request.responseText != null)
                process(request.responseText);// Daten verarbeiten
            else console.error ("Dokument ist leer");
        }
        else console.error ("Uebertragung fehlgeschlagen");
    } else ;          // Uebertragung laeuft noch
}

window.onload = function () {
    // Call the requestData function every 2 seconds (2000 milliseconds)
    setInterval(requestData, 2000);
};