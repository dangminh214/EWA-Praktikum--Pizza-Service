'use strict'
let total_price = 0.00;
 function clickFunction(event) {
     //access to name and price of articel using DOM
     let article_name = event.target.classList.item(0);
     let string_price = document.getElementById(`${article_name}.price`).textContent;

     let float_price = parseFloat(string_price);
     total_price = (total_price + float_price);

     var fixed_total_price = total_price.toFixed(2);
     document.getElementById("total_price").textContent = fixed_total_price;

     //create new option in the Warenkorb
     let newOption = document.createElement("option");
     let article_id;

     //generate article_id using article_name;
     switch (article_name) {
         case "Salami":
             article_id = 1;
             newOption.id = article_id;
             newOption.value = article_id;
             var textNode = document.createTextNode(`${article_name}`);
             newOption.appendChild(textNode);
             var warenkorb = document.getElementById("warenkorb");
             warenkorb.appendChild(newOption);
             break;

         case "Vegetaria":
             article_id = 2;
             newOption.id = article_id;
             newOption.value = article_id;
             var textNode = document.createTextNode(`${article_name}`);
             newOption.appendChild(textNode);
             var warenkorb = document.getElementById("warenkorb");
             warenkorb.appendChild(newOption);
             break;

         case "Spinat-Hühnchen":
             article_id = 3;
             newOption.id = article_id;
             newOption.value = article_id;
             var textNode = document.createTextNode(`${article_name}`);
             newOption.appendChild(textNode);
             var warenkorb = document.getElementById("warenkorb");
             warenkorb.appendChild(newOption);
             break;
     };
};

function deleteAllOptions() {
     //let clicked_article_list = [];
     let warenkorb = document.getElementById("warenkorb");
     while (warenkorb.options.length > 0) {
         warenkorb.remove(0);
     }
};

function deleteSelectedOption() {
    
}