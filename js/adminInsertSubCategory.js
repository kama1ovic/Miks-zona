var btn = $("#btn");
var subCategory = $("#subcategory");
var Acategory = $("#category");
var feeedbackOk = $("#f200");
var feedbackError = $("#f400");
var feedbackError1 = $("#f500");
var div = $("#errors");
var er = $(".er");
var falsee = $(".false");
var errors = [];
btn.click(() => {
    var reSubCategory = /^[A-ZŽĆČŠĐa-zšđčćž]{2,15}(\s[a-zšđčćž]{2,15})*$/;
    var category = document.querySelector("#category");
    var categoryValue = category.options[category.selectedIndex].value;
    var categoryText = category.options[category.selectedIndex].text;
    console.log(categoryText);
    console.log(categoryValue);
    if(categoryValue==="0"){
        Acategory.css("border","1px solid red");
        errors.push("Morate izabrati kategoriju!");
    }
    else{
        Acategory.css("border","");
    }
    if (!reSubCategory.test(subCategory.val())) {
        subCategory.css("border", "1px solid red");
        errors.push("Ime potkategorije ne sme biti kraće od tri karaktera i duže od 15! <br/> Dozvoljena su samo slova!");
    }
    else {
        subCategory.css("border", "");
    }
    if (errors.length > 0) {
        feedbackError1.css("display", "none");
        var error = "";
        for (var x in errors) {
            error += "<p class='false er'>" + errors[x] + "</p>";
        }
        div.html(error);
    }
    else {
        $.ajax({
            url: "php/adminInsertSubCategory.php",
            method: "POST",
            data: {
                subCategory:subCategory.val(),
                categoryID: categoryValue,
                categoryText: categoryText,
                btn: "sent"
            },
            success: function (data, xhr) {
                feedbackError.css("display", "none");
                feedbackError1.css("display", "none");
                feeedbackOk.css("display", "block");
                console.log(categoryText);
            },
            error: function (xhr, status, error) {
                switch (xhr.status) {
                    case 409:
                        feeedbackOk.css("display", "none");
                        feedbackError.css("display", "block");
                        feedbackError1.css("display", "none");
                        div.css("display", "none");
                        break;
                    case 500 :
                        feeedbackOk.css("display", "none");
                        feedbackError1.css("display", "block");
                        feedbackError.css("display", "none");
                        div.css("display", "none");
                        break;
                }
            }

        });
    }
});