$(document).ready(function() {
    $.ajax({
        url: "./ajax.php?function=getUserName",
        data: {},
        type: 'get',
        method: 'GET',
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            //Error in setting status

        },
        success: function(result) {

        }

    });
});