'use strict';   //The code will be in 'strict' format

//Constants used to link to specific parts of bookEventsForm.php
//Majority linked using querySelectors
//l_custDetails, l_tradeCustDetails, and l_termsText linked by getElementById
const l_collectHome = document.querySelector("input[value='home']");
const l_totalBox = document.querySelector("input[name='total']");
const l_custType = document.querySelector("select[name='customerType']");
const l_custDetails = document.getElementById("retCustDetails");
const l_tradeCustDetails = document.getElementById("tradeCustDetails");
const l_termsText = document.getElementById("termsText");
const l_custForename = document.querySelector("input[name='forename']");
const l_custSurname = document.querySelector("input[name='surname']");
const l_compName = document.querySelector("input[name='companyName']");
const l_termsCheckBox = document.querySelector("input[name='termsChkbx']");
const l_submit = document.querySelector("input[name='submit']");

/*------------------------------------------------------------------------------*/

//Function called textRed that changes the terms and conditions text (l_termsText) to red and bold
function textRed() {
    l_termsText.style.color = "red";
    l_termsText.style.fontWeight = "bold";
}

//Function called textBlack that changes the terms and conditions text (l_termsText) to black and the 'normal' style of the font
function textBlack() {
    l_termsText.style.color = "black";
    l_termsText.style.fontWeight = "normal";
}

/*------------------------------------------------------------------------------*/

window.addEventListener('load', function() {    //Adds an event listener on the window
    let runningTotal = 0;   //declaring variable with value 0

    function calculateTotal() { //Function called calculateTotal which will work out the running total/price within the booking form
        runningTotal = 0;
        const l_termsCheckBox = document.querySelectorAll('input[data-price][type=checkbox]');  //constant as value stays the same
        for (let i = 0; i < l_termsCheckBox.length; i++) {
            //if statement. If collection button selected then total is added to the price set which is £5.99
            if (l_termsCheckBox[i].checked) {
                runningTotal = runningTotal + parseFloat(l_termsCheckBox[i].dataset.price);
            }
        }
        //if statement. If collection button selected then total is added to the price set which is £0
        if (l_collectHome.checked) {
            runningTotal = runningTotal + parseFloat(l_collectHome.dataset.price);
        }
        l_totalBox.value = runningTotal.toFixed(2);
    }
    document.onchange = calculateTotal; //calls function and changes on document
});

/*------------------------------------------------------------------------------*/

document.addEventListener('click', function() { //Adds an event listener on document, listening for 'click'
    //if else statement. If all conditions are me then submit button is enabled
    l_submit.disabled = !(l_termsCheckBox.checked && l_custForename.value && l_custSurname.value && l_custType.value && l_custType.value === "ret");
    if (l_termsCheckBox.checked && l_compName.value && l_custType.value && l_custType.value === "trd") {
        l_submit.disabled = false;
    }
    //depending on if the checkbox is checked, calls respective function to changed text colour
    if (l_termsCheckBox.checked) {
        textBlack()
    } else {
        textRed()
    }
    let count = 0;  //declaring variable with value 0
    let l_termsCheckBox2 = document.querySelectorAll('input[data-price][type=checkbox]');
    for (let i = 0; i < l_termsCheckBox2.length; i++) { //For loop will loop through each event (and check to see if they are checked or not
        if (l_termsCheckBox2[i].checked) {
            count++;
        }
    }
    if (count < 1) {    //if variable is less than 1 then the submit button is disabled
        l_submit.disabled = true;
    }
});

/*------------------------------------------------------------------------------*/

//Adds an event listener on the variable l_totalBox
//if value is empty or 0.00 then submit button is disabled
l_totalBox.addEventListener('load', function() {
    if (l_totalBox.value === "" || l_totalBox.value === "0.00") {
        textRed();
        l_submit.disabled = true;
    }
});

/*------------------------------------------------------------------------------*/

//Adds an event listener on the variable l_custType, with 'change' to swap to which if statement
//if value 'trd' then company name input is displayed and customer first and surname is hidden
//vice versa for the other if statement
l_custType.addEventListener('change', function() {
    if (l_custType.value === "trd") {
        l_custDetails.style.visibility = "hidden";
        l_tradeCustDetails.style.visibility = "visible";
    }
    if (l_custType.value === "ret" || l_custType.value === "") {
        l_tradeCustDetails.style.visibility = "hidden";
        l_custDetails.style.visibility = "visible";
    }
});

/**
 * Created by PhpStorm.
 * User: SamJ
 * Date: 18/11/2019
 * Time: 03:50 PM
 */