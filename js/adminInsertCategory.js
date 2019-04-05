var btn = $("#btn");
var category = $("#category");
var feeedbackOk = $("#f200");
var feedbackError = $("#f400");
var feedbackError1 = $("#f500");
var div = $("#errors");
var er = $(".er");
var falsee = $(".false");
var errors = [];
btn.click(() => {
    var reCategory = /^[A-ZŽĆČŠĐ][a-zšđčćž]{2,15}(\s[a-zšđčćž]{2,15})*$/;
    if (!reCategory.test(category.val())) {
        category.css("border", "1px solid red");
        errors.push("Ime kategorije ne sme biti kraće od tri karaktera i duže od 15! <br/> Dozvoljena su samo slova");
    }
    else {
        category.css("border", "");
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
            url: "php/adminInsertCategory.php",
            method: "POST",
            data: {
                category: category.val(),
                btn: "sent"
            },
            success: function (data, xhr) {
                feedbackError.css("display", "none");
                feedbackError1.css("display", "none");
                feeedbackOk.css("display", "block");
            },
            error: function (xhr, status, error) {
                switch (xhr.status) {
                    case 400:
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