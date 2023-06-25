'use strict'
function convertArticleIDToArticleName(id) {
    switch (id) {
        case "1":
            return "Salami";
            break;
        case "2":
            return "Vegetaria";
            break;
        case "3":
            return "Spinat Hühnchen";
            break;
    }
}
function convertStatusIDToStatusName(id) {
    switch (id) {
        case "0":
            return "Bestellt";
            break;
        case "1":
            return "Im Ofen";
            break;
        case "2":
            return "Fertig";
            break;
    }
}
function process(jsonFile) {
    const data = JSON.parse(jsonFile);

    if (!data || data.length === 0) {
        console.error("No pizza data found.");
        return;
    }
    let array_article_id  = []
    let array_article_status = []

    for (var i = 0; i < data[0].article_id.length; i = i+2) {
        array_article_id.push(data[0].article_id[i]);
    }
    for (var i = 0; i < data[0].article_id.length; i = i+2) {
        array_article_status.push(data[0].article_status[i]);
    }

    var index = 0;

    //Console.log only for testing

    //console.log(`article_info_name.${index}`);

    for (var i = 0; i <array_article_id.length; i++) {
        document.getElementById(`article_info_name.${index}`).textContent
            = convertArticleIDToArticleName(array_article_id[i]);
        //console.log(`article_info_name.${index}`);

        document.getElementById(`article_info_status.${index}`).textContent
            = convertStatusIDToStatusName(array_article_status[i]);
        //console.log(`article_info_status.${index}`);
        index++;
    }
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
            if(request.responseText != null) {
                process(request.responseText);// Daten verarbeiten
            }
            else console.error ("Dokument ist leer");
        }
        else console.error ("Uebertragung fehlgeschlagen");
    } else ;          // Uebertragung laeuft noch
}

window.setInterval(requestData, 2000)