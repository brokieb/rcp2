console.log("ASD")
// $.getScript("js/libs/mdb.min.js", function() {
//     alert("Script loaded but not necessarily executed.");
//  });
$(".user-info:not(.content)").click(function(e) {
    if (e.target !== this)
        return;
    $(this).slideUp();
})
$(".exit").click(function() {
    $(".user-info").slideUp();
})


$(".remote-toggle").click(function() {
    var przycisk = $(this);
    $.ajax({
        type: "GET",
        url: "ajax/remote-work-toggle.php",
        data: {
            id: $(this).data("id")
        },
        dataType: "html",
        success: function(zmienna) {
console.log("OK")


        }
    });
})






$(".another-month").click(function(){
var btn = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/user-details-month-details.php",
    data: {
      month: $(this).data("month"),
      id: $(this).data("id")
    },
    dataType: "html",
    success: function (zmienna) {
        $(".month-details").replaceWith(zmienna)
        load_js("user_details_js");
        // load_js("ajax_js");
    },
  });

})


$(".reject-accepted-day").click(function(){
var btn = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/reject_accepted_day.php",
    data: {
      id: $(this).data("id")
    },
    dataType: "html",
    success: function (zmienna) {
    btn.closest("tr").find(".hours").html("USUNIĘTO")
    btn.remove();
    },
  });

})

$(".create-work-day").on('click', function() {
    przycisk = $(this);
    $.ajax({
        type: "GET",
        url: "ajax/create-day.php",
        data: {
            czas: przycisk.closest("tr").find("input[name='work-time']").val(),
            id: przycisk.closest("tr").find("input[name='user-id']").val(),
            data: przycisk.closest("tr").find("input[name='date']").val()
        },
        dataType: "json",
        success: function(zmienna) {
            console.log(przycisk.siblings(
                "input[name='work-time']").val());
            if (zmienna['ans'] == "OK") {
                przycisk.closest("tr").find(".hours").text(przycisk.closest("td").find(
                    "input[name='work-time']").val())
                przycisk.closest(".row").html("dzień pracy poprawnie utworzony");
            }
        }
    });


})