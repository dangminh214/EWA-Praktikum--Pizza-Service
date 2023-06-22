'use strict'

let total_price = 0.00;
let fixed_total_price;
function AddAndShowTotalPrice(price) {
    total_price = total_price + parseFloat(price);
    fixed_total_price = total_price.toFixed(2);
    document.getElementById("total_price").textContent = fixed_total_price;
    document.getElementById("submit_btn").style.display = 'block';
}

function SubAndShowTotalPrice(price) {
    total_price = total_price - parseFloat(price);
    fixed_total_price = total_price.toFixed(2);
    document.getElementById("total_price").textContent = fixed_total_price;
}

function clickFunction(event) {
    //access to name and price of articles using DOM
    let article_name = event.target.classList.item(0);
    console.log(article_name);
    //create new option in the Warenkorb
    let newOption = document.createElement("option");
    var article_id;
    //generate article_id using article_name;
    switch (article_name) {
        case "Salami":
            article_id = "salami";
            newOption.id = article_id;
            newOption.value = 1;
            newOption.setAttribute('data-price', '8.57');
            var textNode = document.createTextNode(`${article_name}`);
            newOption.appendChild(textNode);
            var warenkorb = document.getElementById("warenkorb");
            warenkorb.appendChild(newOption);
            break;

        case "Vegetaria":
            article_id = "vegetaria";
            newOption.id = article_id;
            newOption.value = 2;
            newOption.setAttribute('data-price', '12.5');
            var textNode = document.createTextNode(`${article_name}`);
            newOption.appendChild(textNode);
            var warenkorb = document.getElementById("warenkorb");
            warenkorb.appendChild(newOption);
            break;

        case "Spinat-Hühnchen":
            article_id = "spinat-huenchen";
            newOption.id = article_id;
            newOption.value = 3;
            newOption.setAttribute('data-price', '11.99');
            var textNode = document.createTextNode(`${article_name}`);
            newOption.appendChild(textNode);
            var warenkorb = document.getElementById("warenkorb");
            warenkorb.appendChild(newOption);
            break;
    }
    AddAndShowTotalPrice(newOption.getAttribute('data-price'));

}

function deleteAllOptions() {
    var warenkorb = document.getElementById("warenkorb");
    while (warenkorb.options.length > 0) {
        warenkorb.remove(0);
    }

    total_price = 0;
    document.getElementById("total_price").textContent = total_price ;
    document.getElementById("submit_btn").style.display = 'none';
}

function deleteSelectedOption() {
    var warenkorb = document.getElementById("warenkorb");
    for (let i = 0; i < warenkorb.options.length; i++) {
            while (warenkorb.options[i].selected) {
                SubAndShowTotalPrice(warenkorb.options[i].getAttribute('data-price'));
                warenkorb.remove(i);
                if (warenkorb.options.length == 0)
                    document.getElementById("submit_btn").style.display = 'none';
            }
        }
}

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
