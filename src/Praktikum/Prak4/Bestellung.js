let total_price = 0.00;
let fixed_total_price;

function showBestellenBtnWhenInputAdress () {
    "use strict";
    const input_address = document.getElementById("address_input");
    const bestellen_btn = document.getElementById("submit_btn");
    var warenkorb = document.getElementById("warenkorb");
    if ((input_address.value.trim()) && (warenkorb.options.length!=0)) {
        bestellen_btn.style.display = "block";
    }
    else {
        bestellen_btn.style.display = "none";
    }
}
function AddAndShowTotalPrice(price) {
    "use strict";
    total_price = total_price + parseFloat(price);
    fixed_total_price = total_price.toFixed(2);
    document.getElementById("total_price").textContent = fixed_total_price;

    var address_input = document.getElementById("address_input");

    if (address_input.value!=="") {
        document.getElementById("submit_btn").style.display = 'block';
    }
}

function SubAndShowTotalPrice(price) {
    "use strict";
    total_price = total_price - parseFloat(price);
    fixed_total_price = total_price.toFixed(2);
    document.getElementById("total_price").textContent = fixed_total_price;
}

function clickFunction(event) {
    "use strict";
    //access to name and price of articles using DOM
    let article_name = event.target.getAttribute("data-name");
    //create new option in the Warenkorb
    let newOption = document.createElement("option");
    //generate article_id using article_name;
            newOption.id = event.target.getAttribute("data-name");
            newOption.value = event.target.getAttribute("data-value");
            newOption.setAttribute('data-name',  event.target.getAttribute("data-name"));
            newOption.setAttribute('data-price', event.target.getAttribute("data-price"));
            var textNode = document.createTextNode(`${article_name}`);
            newOption.appendChild(textNode);
            var warenkorb = document.getElementById("warenkorb");
            warenkorb.appendChild(newOption);
    AddAndShowTotalPrice(newOption.getAttribute('data-price'));
}

function deleteAllOptions() {
    "use strict";
    var warenkorb = document.getElementById("warenkorb");
    while (warenkorb.options.length > 0) {
        warenkorb.remove(0);
    }
    total_price = 0;
    document.getElementById("total_price").textContent = total_price ;
    document.getElementById("submit_btn").style.display = 'none';
}

function deleteSelectedOption() {
    "use strict";
    var warenkorb = document.getElementById("warenkorb");
    for (let i = 0; i < warenkorb.options.length; i++) {
        while (warenkorb.options[i].selected) {
            SubAndShowTotalPrice(warenkorb.options[i].getAttribute('data-price'));
            warenkorb.remove(i);
            if (warenkorb.options.length === 0)
                document.getElementById("submit_btn").style.display = 'none';
        }
    }
}

function select_all_items() {
    "use strict";
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

