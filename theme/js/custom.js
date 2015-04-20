// Initialise the Superfish Menu  
$(document).ready(function() { 
        $('#primary-nav ul').superfish({ 
            delay: 200,
            animation: {opacity:'show', height:'show'},
            speed: 'fast',
            autoArrows: false,
            dropShadows: false
        }); 
    });

// Select
$(function() {

    $("#page-changer select").change(function() {
        window.location = $("#page-changer select option:selected").val();
    })

});
