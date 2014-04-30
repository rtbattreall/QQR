$(document).ready(function () {

    $.ajaxSetup({
        // Disable caching of AJAX responses
        cache: false
    });

    $(".alert").delay(5000).fadeOut("slow", function () { $(this).remove(); });

     $("#btn-contact-reset").click(function () {
         Reset();
     });

     Reset();
});

function Reset() {
    $("#txt-contact-message").val("");
    $("#txt-contact-email").val("");
    $("#txt-contact-companyname").val("");
    $("#txt-contact-name").val("");
}