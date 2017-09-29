$(document).ready(function() {
    $.ajax({
        url: "./",
        data: {},
        type: 'post',
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            //Error in setting status
            console.log("Error in checking current status via ajax")
        },
        success: function() {
            console.log("hey");
        }
    });
});