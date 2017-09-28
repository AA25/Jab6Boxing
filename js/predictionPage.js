//This are event listeners that will listen to which label is clicked in each of the 6 matches
$("#match1 label").click(function(event) {
    $("#match1 label").css("background", "none");
    var clickedOn = event.currentTarget.htmlFor;
    $("label[for='" + clickedOn + "']").css("background", "linear-gradient(90deg, #122d68 20%, #d61726");
});

$("#match2 label").click(function(event) {
    $("#match2 label").css("background", "none");
    var clickedOn = event.currentTarget.htmlFor;
    $("label[for='" + clickedOn + "']").css("background", "linear-gradient(90deg, #122d68 20%, #d61726");
});

$("#match3 label").click(function(event) {
    $("#match3 label").css("background", "none");
    var clickedOn = event.currentTarget.htmlFor;
    $("label[for='" + clickedOn + "']").css("background", "linear-gradient(90deg, #122d68 20%, #d61726");
});

$("#match4 label").click(function(event) {
    $("#match4 label").css("background", "none");
    var clickedOn = event.currentTarget.htmlFor;
    $("label[for='" + clickedOn + "']").css("background", "linear-gradient(90deg, #122d68 20%, #d61726");
});

$("#match5 label").click(function(event) {
    $("#match5 label").css("background", "none");
    var clickedOn = event.currentTarget.htmlFor;
    $("label[for='" + clickedOn + "']").css("background", "linear-gradient(90deg, #122d68 20%, #d61726");
});

$("#match6 label").click(function(event) {
    $("#match6 label").css("background", "none");
    var clickedOn = event.currentTarget.htmlFor;
    $("label[for='" + clickedOn + "']").css("background", "linear-gradient(90deg, #122d68 20%, #d61726");
});