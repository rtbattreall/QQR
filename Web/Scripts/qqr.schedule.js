$(document).ready(function () {

    $.ajaxSetup({
        // Disable caching of AJAX responses
        cache: false
    });

    $(".alert").delay(5000).fadeOut("slow", function () { $(this).remove(); });

    $("#btn-schedule-reset").click(function () {
        Reset();
    });

    $("#txt-schedule-datetime").datetimepicker(
       {
           timeFormat: "hh:mm tt",
           hourMin: 7,
           hourMax: 19
       }).attr('readonly', 'readonly');

    Reset()
});

function Reset() {
    $("#txt-schedule-attorneyname").val("");
    $("#txt-schedule-phonenumber").val("");
    $("#txt-schedule-contactname").val("");
    $("#txt-schedule-datetime").val("");
    $("#txt-schedule-email").val("");
    $("#txt-schedule-placeoftrial").val("");
    $("#txt-schedule-address").val("");
    $("#txt-schedule-city").val("");
    $("#ddl-schedule-state").get(0).selectedIndex = 0;
    $("#ddl-schedule-estimatedtime").get(0).selectedIndex = 0;
    $("#txt-schedule-case").val("");
    $("#txt-schedule-docket").val("");
    $("#txt-schedule-casecomments").val("");
    $("#txt-schedule-deliverycomments").val("");
    $("#rdb-schedule-video2").prop("checked", true);
    $('#ddl-schedule-turnaroundtime').get(0).selectedIndex = 0;
}


