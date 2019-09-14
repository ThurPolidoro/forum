$(document).ready(function(){
    $("#btn").click(function() {
        var val = "Hi";
        $.ajax ({
            url: "ajax.php",
            data: { val : val },
            success: function( result ) {
                alert("Hi, testing");
                alert( result );
            }
        });
    });
});