'use strict'

function calculateToTalPrice() {
    var total_price = 0.00;
    var fixed_total_price = 0.00;
    var warenkorb = document.getElementById("warenkorb");
    if (warenkorb.options.length > 0) {
        for (let i = 0; i < warenkorb.options.length; i++) {
            var string_price = warenkorb.options[i].id;
            var float_price = parseFloat(string_price);
            total_price = (total_price + float_price);
            fixed_total_price = total_price.toFixed(2);
        }
    }
    else {
        console.log("Warenkorb ist leer");
    }
    document.getElementById("total_price").textContent = fixed_total_price;
}

setInterval(calculateToTalPrice, 1000);
function clickFunction(event) {
    //access to name and price of articel using DOM
    let article_name = event.target.classList.item(0);
    let string_price = document.getElementById(`${article_name}.price`).textContent;

    let float_price = parseFloat(string_price);

    //create new option in the Warenkorb
    let newOption = document.createElement("option");
    let article_id;

    //generate article_id using article_name;
    switch (article_name) {
        case "Salami":
            article_id = 1;
            newOption.id = float_price;
            newOption.value = article_id;
            var textNode = document.createTextNode(`${article_name}`);
            newOption.appendChild(textNode);
            var warenkorb = document.getElementById("warenkorb");
            warenkorb.appendChild(newOption);
            break;

        case "Vegetaria":
            article_id = 2;
            newOption.id = float_price;
            newOption.value = article_id;
            var textNode = document.createTextNode(`${article_name}`);
            newOption.appendChild(textNode);
            var warenkorb = document.getElementById("warenkorb");
            warenkorb.appendChild(newOption);
            break;

        case "Spinat-Hühnchen":
            article_id = 3;
            newOption.id = float_price;
            newOption.value = article_id;
            var textNode = document.createTextNode(`${article_name}`);
            newOption.appendChild(textNode);
            var warenkorb = document.getElementById("warenkorb");
            warenkorb.appendChild(newOption);
            break;
    }
}

function deleteAllOptions() {
    let warenkorb = document.getElementById("warenkorb");
    while (warenkorb.options.length > 0) {
        warenkorb.remove(0);
    }
}

function deleteSelectedOption() {
    let warenkorb = document.getElementById("warenkorb");
    for (let i = 0; i < warenkorb.options.length; i++) {
        var option = warenkorb.options[i];
        if (option.selected) {
            warenkorb.remove(i);
        }
    }
}

//TODO: FIX select_all_items()
function select_all_items() {
    var warenkorb = document.getElementById("warenkorb");
    for (let i = 0; i < warenkorb.options.length; i++) {
        var option = warenkorb.options[i];
        if(!(option.selected)) {
            option.setAttribute("selected", "selected");
        }
    }
    var form = document.getElementById("BestellungsInfos");
    form.submit();
}